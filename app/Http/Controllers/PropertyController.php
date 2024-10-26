<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PropertyController extends Controller
{
    protected $imageSizes = [
        'thumb' => [150, 150],
        'medium' => [400, 300],
        'large' => [800, 600]
    ];

    public function __construct()
    {
        $this->middleware('auth');
        //$this->authorizeResource(Property::class, 'property');
    }

    public function index()
    {
        $properties = Property::query()
            ->with(['images', 'user'])
            ->withCount('reservations')
            ->when(request('search'), function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%");
                });
            })
            ->when(request('type'), function($query, $type) {
                $query->where('type', $type);
            })
            ->when(request('status'), function($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('min_price'), function($query, $price) {
                $query->where('price', '>=', $price);
            })
            ->when(request('max_price'), function($query, $price) {
                $query->where('price', '<=', $price);
            })
            ->when(request('bedrooms'), function($query, $bedrooms) {
                $query->where('bedrooms', '>=', $bedrooms);
            })
            ->when(request('bathrooms'), function($query, $bathrooms) {
                $query->where('bathrooms', '>=', $bathrooms);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        $property = new Property();
    return view('properties.create', compact('property'));
    }

    public function store(PropertyStoreRequest $request)
    {
        try {
            \DB::beginTransaction();

            $property = Property::create($request->validated());

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $this->imageService->handlePropertyImage($image, $property->id);
                    $property->images()->create([
                        'image_path' => $imagePath,
                        'is_primary' => $property->images()->count() === 0
                    ]);
                }
            }

            \DB::commit();
            return redirect()->route('properties.index')
                ->with('success', 'Propriété créée avec succès');

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la création.')
                        ->withInput();
        }
    }

    public function show(Property $property)
    {
        $property->load(['images', 'user', 'reservations.user']);
        
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }

    public function update(PropertyUpdateRequest $request, Property $property)
    {
        try {
            \DB::beginTransaction();

            $data = $request->validated();
            
            if ($property->title !== $data['title']) {
                $data['slug'] = $this->generateUniqueSlug($data['title']);
            }

            // Mise à jour de la propriété
            $property->update($data);

            // Gestion des nouvelles images
            if ($request->hasFile('images')) {
                $this->handleImageUpload($property, $request->file('images'));
            }

            \DB::commit();

            return redirect()->route('properties.index')
                ->with('success', 'Propriété mise à jour avec succès.');

        } catch (\Exception $e) {
            \DB::rollBack();
            logger()->error('Erreur lors de la mise à jour de la propriété:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Une erreur est survenue lors de la mise à jour de la propriété.')
                        ->withInput();
        }
    }

    public function destroy(Property $property)
    {
        try {
            \DB::beginTransaction();

            // Suppression des images
            foreach ($property->images as $image) {
                $this->deletePropertyImage($image);
            }

            // Suppression de la propriété
            $property->delete();

            \DB::commit();

            return redirect()->route('properties.index')
                ->with('success', 'Propriété supprimée avec succès.');

        } catch (\Exception $e) {
            \DB::rollBack();
            logger()->error('Erreur lors de la suppression de la propriété:', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Une erreur est survenue lors de la suppression de la propriété.');
        }
    }

    public function deleteImage(PropertyImage $image)
    {
        try {
            $this->deletePropertyImage($image);
            return back()->with('success', 'Image supprimée avec succès.');
        } catch (\Exception $e) {
            logger()->error('Erreur lors de la suppression de l\'image:', [
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Une erreur est survenue lors de la suppression de l\'image.');
        }
    }

    public function setPrimaryImage(PropertyImage $image)
    {
        try {
            \DB::beginTransaction();

            $image->property->images()->update(['is_primary' => false]);
            $image->update(['is_primary' => true]);

            \DB::commit();

            return back()->with('success', 'Image principale définie avec succès.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    protected function handleImageUpload($property, array $images)
    {
        foreach ($images as $image) {
            // Validation supplémentaire
            if (!$image->isValid() || 
                !in_array($image->getClientOriginalExtension(), ['jpg', 'jpeg', 'png'])) {
                continue;
            }

            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $basePath = 'properties/' . $property->id;

            // Créer les différentes tailles d'images
            foreach ($this->imageSizes as $size => $dimensions) {
                $resizedImage = Image::make($image)
                    ->fit($dimensions[0], $dimensions[1], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode($image->getClientOriginalExtension(), 80);

                Storage::disk('public')->put(
                    $basePath . '/' . $size . '/' . $filename,
                    $resizedImage->stream()
                );
            }

            // Sauvegarder l'original
            $originalPath = $image->storeAs($basePath . '/original', $filename, 'public');

            // Créer l'enregistrement dans la base de données
            $property->images()->create([
                'image_path' => $originalPath,
                'is_primary' => $property->images()->count() === 0
            ]);
        }
    }

    protected function deletePropertyImage(PropertyImage $image)
    {
        // Supprimer toutes les variations de l'image
        $basePath = 'properties/' . $image->property_id;
        foreach (['thumb', 'medium', 'large', 'original'] as $size) {
            $path = $basePath . '/' . $size . '/' . basename($image->image_path);
            Storage::disk('public')->delete($path);
        }

        // Supprimer l'enregistrement
        $image->delete();
    }

    protected function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = 1;

        while (Property::where('slug', $slug)->exists()) {
            $slug = Str::slug($title) . '-' . $count++;
        }

        return $slug;
    }
}

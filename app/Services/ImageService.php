<?php

namespace App\Services;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    protected $manager;
    protected $imageSizes;

    public function __construct()
    {
        $this->manager = ImageManager::withDriver(new Driver());
        
        // Définir les tailles d'images
        $this->imageSizes = [
            'thumb' => [150, 150],
            'medium' => [400, 300],
            'large' => [800, 600]
        ];
    }

   
    public function handlePropertyImage($image, $propertyId)
    {
        try {
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $basePath = 'properties/' . $propertyId;

            // Créer les différentes tailles
            foreach ($this->imageSizes as $size => $dimensions) {
                $img = $this->manager->read($image->path());
                
                $img->cover($dimensions[0], $dimensions[1]);

                Storage::disk('public')->put(
                    $basePath . '/' . $size . '/' . $filename,
                    $img->toJpg()->toString()
                );
            }

            // Sauvegarder l'original
            return $image->storeAs(
                $basePath . '/original',
                $filename,
                'public'
            );

        } catch (\Exception $e) {
            logger()->error('Erreur lors du traitement de l\'image:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e;
        }
    }

    public function deletePropertyImages($imagePath, $propertyId)
    {
        try {
            $filename = basename($imagePath);
            $basePath = 'properties/' . $propertyId;

            // Supprimer toutes les versions
            foreach (array_merge(array_keys($this->imageSizes), ['original']) as $size) {
                Storage::disk('public')->delete($basePath . '/' . $size . '/' . $filename);
            }

            return true;
        } catch (\Exception $e) {
            logger()->error('Erreur lors de la suppression des images:', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function getImageUrl($path, $size = 'original')
    {
        if (!$path) {
            return null;
        }

        $directory = dirname($path);
        $filename = basename($path);
        
        return Storage::disk('public')->url("{$directory}/{$size}/{$filename}");
    }

    public function optimizeImage($image)
    {
        try {
            $img = $this->manager->make($image);
            
            // Optimisation de base
            $img->orientate(); // Corriger l'orientation EXIF
            $img->encode(null, 80); // Compression à 80%
            
            return $img;
        } catch (\Exception $e) {
            logger()->error('Erreur lors de l\'optimisation de l\'image:', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function isValidImage($file)
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxSize = 5242880; // 5MB

        return $file->isValid() && 
               in_array($file->getMimeType(), $allowedMimes) && 
               $file->getSize() <= $maxSize;
    }

    public function getImageDimensions($path)
    {
        try {
            $img = $this->manager->make(Storage::disk('public')->get($path));
            return [
                'width' => $img->width(),
                'height' => $img->height()
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function handlePropertyImageAdvanced($image, $propertyId)
{
    try {
        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
        $basePath = 'properties/' . $propertyId;

        foreach ($this->imageSizes as $size => $dimensions) {
            $img = $this->manager->read($image->path());
            
            // Appliquer des modifications avancées
            $img->cover($dimensions[0], $dimensions[1])
                ->brightness(5)              // Légère augmentation de la luminosité
                ->contrast(10)              // Augmentation du contraste
                ->greyscale()              // Conversion en niveaux de gris (si nécessaire)
                ->sharpen(15);             // Amélioration de la netteté

            // Ajouter un filigrane (si nécessaire)
            /*
            $watermark = $this->manager->read(public_path('watermark.png'));
            $img->place($watermark, 'bottom-right', 10, 10);
            */

            Storage::disk('public')->put(
                $basePath . '/' . $size . '/' . $filename,
                $img->toJpg(80)->toString()
            );
        }

        return $image->storeAs(
            $basePath . '/original',
            $filename,
            'public'
        );

    } catch (\Exception $e) {
        logger()->error('Erreur lors du traitement de l\'image:', [
            'error' => $e->getMessage()
        ]);
        throw $e;
    }
}
}

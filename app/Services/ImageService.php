<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Str;

class ImageService
{
    protected $cacheTime = 60 * 24; // 24 heures

    public function getImage($path, $size = 'medium')
    {
        $cacheKey = "image_{$path}_{$size}";

        return Cache::remember($cacheKey, $this->cacheTime, function() use ($path, $size) {
            return $this->processImage($path, $size);
        });
    }

    protected function processImage($path, $size)
    {
        if (!Storage::disk('public')->exists($path)) {
            return null;
        }

        $dimensions = $this->getImageDimensions($size);
        $image = Image::make(Storage::disk('public')->get($path));

        // Redimensionner l'image selon la taille demandée
        $image->fit($dimensions['width'], $dimensions['height'], function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return [
            'url' => Storage::disk('public')->url($path),
            'width' => $image->width(),
            'height' => $image->height(),
            'data' => base64_encode($image->encode())
        ];
    }

    protected function getImageDimensions($size)
    {
        return [
            'thumb' => ['width' => 150, 'height' => 150],
            'medium' => ['width' => 400, 'height' => 300],
            'large' => ['width' => 800, 'height' => 600]
        ][$size] ?? ['width' => 400, 'height' => 300];
    }

    public function handlePropertyImage($image, $propertyId)
    {
        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
        $basePath = 'properties/' . $propertyId;

        // Créer les différentes tailles
        foreach ($this->imageSizes as $size => $dimensions) {
            $img = $this->manager->make($image->path());
            
            $img->fit($dimensions[0], $dimensions[1], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            Storage::disk('public')->put(
                $basePath . '/' . $size . '/' . $filename,
                $img->encode()
            );
        }

        // Sauvegarder l'original
        $originalPath = $image->storeAs(
            $basePath . '/original',
            $filename,
            'public'
        );

        return $originalPath;
    }

    public function deletePropertyImages($imagePath, $propertyId)
    {
        $filename = basename($imagePath);
        $basePath = 'properties/' . $propertyId;

        foreach (array_merge(array_keys($this->imageSizes), ['original']) as $size) {
            Storage::disk('public')->delete($basePath . '/' . $size . '/' . $filename);
        }
    }
}
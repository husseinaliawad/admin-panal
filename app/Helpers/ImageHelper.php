<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageHelper
{
    /**
     * Get the correct image URL for production and development
     */
    public static function getImageUrl($imagePath)
    {
        if (empty($imagePath)) {
            return asset('storage/images/logo.jpg'); // Use logo from storage
        }

        // Check if storage link exists
        if (File::exists(public_path('storage'))) {
            return asset('storage/' . $imagePath);
        }

        // Fallback: try to serve from storage directly
        $fullPath = storage_path('app/public/' . $imagePath);
        if (File::exists($fullPath)) {
            // Create a route to serve the file
            return route('serve.image', ['path' => $imagePath]);
        }

        // Final fallback: use logo from storage
        return asset('storage/images/logo.jpg');
    }

    /**
     * Get brand image URL
     */
    public static function getBrandImage($brand)
    {
        return self::getImageUrl($brand->image);
    }

    /**
     * Get category image URL
     */
    public static function getCategoryImage($category)
    {
        return self::getImageUrl($category->image);
    }

    /**
     * Get product image URL
     */
    public static function getProductImage($product, $index = 0)
    {
        $images = $product->images ?? [];
        $imagePath = $images[$index] ?? null;
        return self::getImageUrl($imagePath);
    }
} 
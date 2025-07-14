<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageHelper
{
    /**
     * Get the correct image URL for production (بدون symlink)
     * استخدام مسارات مباشرة في public
     */
    public static function getImageUrl($imagePath)
    {
        if (empty($imagePath)) {
            return asset('images-/logo.jpg');
        }

        // إذا كان المسار يبدأ بـ brands/ أو categories/ أو products/ أو images/
        if (preg_match('/^(brands|categories|products|images)\//', $imagePath)) {
            return asset('storage/' . $imagePath);
        }

        // إذا كان مسار مباشر
        return asset('storage/' . $imagePath);
    }

    /**
     * Get brand image URL
     */
    public static function getBrandImage($brand)
    {
        if (empty($brand->image)) {
            return asset('images-/logo.jpg');
        }
        
        // تأكد من أن المسار يبدأ بـ brands/
        $imagePath = $brand->image;
        if (!str_starts_with($imagePath, 'brands/')) {
            $imagePath = 'brands/' . $imagePath;
        }
        
        return self::getImageUrl($imagePath);
    }

    /**
     * Get category image URL
     */
    public static function getCategoryImage($category)
    {
        if (empty($category->image)) {
            return asset('images-/logo.jpg');
        }
        
        // تأكد من أن المسار يبدأ بـ categories/
        $imagePath = $category->image;
        if (!str_starts_with($imagePath, 'categories/')) {
            $imagePath = 'categories/' . $imagePath;
        }
        
        return self::getImageUrl($imagePath);
    }

    /**
     * Get product image URL
     */
    public static function getProductImage($product, $index = 0)
    {
        $images = $product->images ?? [];
        $imagePath = $images[$index] ?? null;
        
        if (empty($imagePath)) {
            return asset('images-/logo.jpg');
        }
        
        // تأكد من أن المسار يبدأ بـ products/
        if (!str_starts_with($imagePath, 'products/')) {
            $imagePath = 'products/' . $imagePath;
        }
        
        return self::getImageUrl($imagePath);
    }
} 
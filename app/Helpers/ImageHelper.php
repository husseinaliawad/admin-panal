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
            return asset($imagePath);
        }

        // إذا كان مسار مباشر
        return asset($imagePath);
    }

    /**
     * Get brand image URL
     */
    public static function getBrandImage($brand)
    {
        if (empty($brand->image)) {
            return asset('images-/logo.jpg');
        }
        
        // إذا كان المسار اسم ملف فقط، أضف brands/
        $imagePath = $brand->image;
        if (!str_starts_with($imagePath, 'brands/') && !str_starts_with($imagePath, '/')) {
            $imagePath = 'brands/' . $imagePath;
        }
        
        return asset($imagePath);
    }

    /**
     * Get category image URL
     */
    public static function getCategoryImage($category)
    {
        if (empty($category->image)) {
            return asset('images-/logo.jpg');
        }
        
        // إذا كان المسار اسم ملف فقط، أضف categories/
        $imagePath = $category->image;
        if (!str_starts_with($imagePath, 'categories/') && !str_starts_with($imagePath, '/')) {
            $imagePath = 'categories/' . $imagePath;
        }
        
        return asset($imagePath);
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
        
        // إذا كان المسار اسم ملف فقط، أضف products/
        if (!str_starts_with($imagePath, 'products/') && !str_starts_with($imagePath, '/')) {
            $imagePath = 'products/' . $imagePath;
        }
        
        return asset($imagePath);
    }
} 
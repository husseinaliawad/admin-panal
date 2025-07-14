<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageHelper
{
    /**
     * Get the correct image URL for production (بدون symlink)
     * استخدام public/storage مباشرة
     */
    public static function getImageUrl($imagePath)
    {
        if (empty($imagePath)) {
            return asset('storage/images/logo.jpg');
        }

        // التحقق من وجود الصورة في public/storage
        $publicPath = public_path('storage/' . $imagePath);
        if (File::exists($publicPath)) {
            return asset('storage/' . $imagePath);
        }

        // إذا لم توجد الصورة، استخدم اللوغو
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

    /**
     * Copy image to public/storage (بدون symlink)
     */
    public static function copyImageToPublic($sourcePath, $destinationPath)
    {
        $publicDestination = public_path('storage/' . $destinationPath);
        
        // إنشاء المجلد إذا لم يكن موجود
        $dir = dirname($publicDestination);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        if (File::exists($sourcePath)) {
            return File::copy($sourcePath, $publicDestination);
        }
        
        return false;
    }

    /**
     * Save uploaded image directly to public/storage
     */
    public static function saveUploadedImage($file, $folder = 'images')
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $destination = public_path("storage/$folder");
        
        // إنشاء المجلد إذا لم يكن موجود
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }
        
        if ($file->move($destination, $filename)) {
            return "$folder/$filename";
        }
        
        return null;
    }
} 
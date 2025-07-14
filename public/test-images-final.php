<?php
/**
 * 🔧 اختبار شامل لنظام الصور المحدث
 * استخدم هذه الأداة للتأكد من أن كل شيء يعمل محلياً قبل الرفع
 */

echo "<h1>🔧 اختبار شامل لنظام الصور</h1>";
echo "<style>
body{font-family:Arial;margin:40px;} 
.success{color:green;} 
.error{color:red;} 
.info{color:blue;}
.warning{color:orange;}
.test-section{background:#f5f5f5;padding:20px;border-radius:8px;margin:20px 0;}
</style>";

// تحديد المسار الصحيح (نحن الآن في مجلد public)
$basePath = __DIR__; // مجلد public

// 1. اختبار المجلدات
echo "<div class='test-section'>";
echo "<h2>📁 اختبار المجلدات</h2>";
$folders = ['brands', 'categories', 'products', 'images-'];
foreach ($folders as $folder) {
    $path = "$basePath/$folder";
    if (is_dir($path)) {
        echo "<div class='success'>✅ المجلد موجود: $folder</div>";
    } else {
        if (mkdir($path, 0755, true)) {
            echo "<div class='info'>📁 تم إنشاء المجلد: $folder</div>";
        } else {
            echo "<div class='error'>❌ فشل في إنشاء المجلد: $folder</div>";
        }
    }
}
echo "</div>";

// 2. إنشاء صور اختبار
echo "<div class='test-section'>";
echo "<h2>🖼️ إنشاء صور اختبار</h2>";
$testImages = [
    'brands/test-brand.jpg',
    'categories/test-category.jpg', 
    'products/test-product.jpg',
    'images-/test-image.jpg'
];

foreach ($testImages as $image) {
    $fullPath = "$basePath/$image";
    if (!file_exists($fullPath)) {
        // إنشاء صورة اختبار بسيطة
        $img = imagecreate(200, 100);
        $bg = imagecolorallocate($img, 200, 200, 200);
        $text = imagecolorallocate($img, 0, 0, 0);
        $text_parts = explode('/', $image);
        $folder = $text_parts[0];
        imagestring($img, 3, 50, 40, "TEST $folder", $text);
        imagejpeg($img, $fullPath);
        imagedestroy($img);
        echo "<div class='info'>🖼️ تم إنشاء صورة اختبار: $image</div>";
    } else {
        echo "<div class='success'>✅ صورة اختبار موجودة: $image</div>";
    }
}
echo "</div>";

// 3. اختبار الوصول للصور
echo "<div class='test-section'>";
echo "<h2>🌐 اختبار الوصول للصور</h2>";
$baseUrl = 'http://127.0.0.1:8000';
foreach ($testImages as $image) {
    $url = "$baseUrl/$image";
    echo "<div class='info'>🔗 <a href='$url' target='_blank'>$url</a></div>";
}
echo "</div>";

// 4. اختبار قواعد إعادة التوجيه
echo "<div class='test-section'>";
echo "<h2>🔄 اختبار قواعد إعادة التوجيه</h2>";
$redirectTests = [
    '/public/brands/test-brand.jpg' => '/brands/test-brand.jpg',
    '/public/categories/test-category.jpg' => '/categories/test-category.jpg',
    '/public/products/test-product.jpg' => '/products/test-product.jpg',
    '/storage/brands/test-brand.jpg' => '/brands/test-brand.jpg'
];

foreach ($redirectTests as $old => $new) {
    echo "<div class='info'>🔄 <strong>$old</strong> → <strong>$new</strong></div>";
    echo "<div class='warning'>👆 اختبر هذا المسار: <a href='$baseUrl$old' target='_blank'>$baseUrl$old</a></div>";
}
echo "</div>";

// 5. اختبار إعدادات Laravel
echo "<div class='test-section'>";
echo "<h2>⚙️ اختبار إعدادات Laravel</h2>";
try {
    // محاكاة Storage::disk
    $config = [
        'public_brands' => [
            'root' => $basePath . '/brands',
            'url' => '/brands'
        ],
        'public_categories' => [
            'root' => $basePath . '/categories', 
            'url' => '/categories'
        ],
        'public_products' => [
            'root' => $basePath . '/products',
            'url' => '/products'
        ]
    ];
    
    foreach ($config as $diskName => $diskConfig) {
        if (is_dir($diskConfig['root'])) {
            echo "<div class='success'>✅ قرص $diskName: {$diskConfig['root']} → {$diskConfig['url']}</div>";
        } else {
            echo "<div class='error'>❌ قرص $diskName: مسار غير موجود {$diskConfig['root']}</div>";
        }
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ خطأ في الإعدادات: " . $e->getMessage() . "</div>";
}
echo "</div>";

// 6. عرض محتوى المجلدات
echo "<div class='test-section'>";
echo "<h2>📋 محتوى المجلدات</h2>";
foreach ($folders as $folder) {
    $path = "$basePath/$folder";
    if (is_dir($path)) {
        $files = array_diff(scandir($path), ['.', '..']);
        echo "<h3>📂 $folder:</h3>";
        if (!empty($files)) {
            echo "<ul>";
            foreach ($files as $file) {
                $size = filesize("$path/$file");
                echo "<li>$file (" . round($size/1024, 2) . " KB)</li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='info'>لا توجد ملفات</p>";
        }
    }
}
echo "</div>";

// 7. اختبار .htaccess
echo "<div class='test-section'>";
echo "<h2>🔧 اختبار .htaccess</h2>";
$htaccessPath = "$basePath/.htaccess";
if (file_exists($htaccessPath)) {
    echo "<div class='success'>✅ ملف .htaccess موجود</div>";
    $content = file_get_contents($htaccessPath);
    if (strpos($content, 'RewriteRule ^public/brands/') !== false) {
        echo "<div class='success'>✅ قواعد إعادة التوجيه موجودة</div>";
    } else {
        echo "<div class='error'>❌ قواعد إعادة التوجيه غير موجودة</div>";
    }
} else {
    echo "<div class='error'>❌ ملف .htaccess غير موجود</div>";
}
echo "</div>";

echo "<div class='test-section'>";
echo "<h2>🎯 الخطوات التالية</h2>";
echo "<ol>";
echo "<li>اختبر الروابط أعلاه في المتصفح</li>";
echo "<li>إذا عملت محلياً، استخدم <a href='prepare-upload.php'>prepare-upload.php</a></li>";
echo "<li>ارفع الملفات للخادم</li>";
echo "<li>احذف هذا الملف بعد الانتهاء!</li>";
echo "</ol>";
echo "</div>";

?> 
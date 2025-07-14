<?php
/**
 * إصلاح سريع للصور - تشغيل مباشرة على الاستضافة
 */

header('Content-Type: text/html; charset=utf-8');
echo "<h2>🔧 إصلاح الصور - تشغيل مباشر</h2>";
echo "<style>body{font-family:Arial;margin:40px;line-height:1.6;} .success{color:green;} .error{color:red;} .info{color:blue;} .warning{color:orange;}</style>";

// 1. إنشاء المجلدات المطلوبة
echo "<h3>📁 إنشاء المجلدات:</h3>";
$folders = [
    'public/storage',
    'public/storage/brands',
    'public/storage/categories',
    'public/storage/products',
    'public/storage/images'
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        if (mkdir($folder, 0755, true)) {
            echo "<div class='success'>✅ تم إنشاء: $folder</div>";
        } else {
            echo "<div class='error'>❌ فشل إنشاء: $folder</div>";
        }
    } else {
        echo "<div class='info'>📁 موجود: $folder</div>";
    }
}

// 2. نسخ الصور من public/images- إلى public/storage/images
echo "<h3>📸 نسخ الصور:</h3>";
if (is_dir('public/images-')) {
    $sourceFiles = glob('public/images-/*.{jpg,jpeg,png,gif,webp,avif}', GLOB_BRACE);
    echo "<div class='info'>📂 وُجد " . count($sourceFiles) . " ملف في public/images-</div>";
    
    foreach ($sourceFiles as $sourceFile) {
        $filename = basename($sourceFile);
        $destination = 'public/storage/images/' . $filename;
        
        if (copy($sourceFile, $destination)) {
            echo "<div class='success'>✅ تم نسخ: $filename</div>";
        } else {
            echo "<div class='error'>❌ فشل نسخ: $filename</div>";
        }
    }
} else {
    echo "<div class='warning'>⚠️ مجلد public/images- غير موجود</div>";
}

// 3. إنشاء صور العلامات التجارية
echo "<h3>🏷️ إنشاء صور العلامات التجارية:</h3>";
$logoSources = [
    'public/storage/images/logo.jpg',
    'public/storage/images/logo.webp',
    'public/images-/logo.jpg',
    'public/images-/logo.webp'
];

$logoFile = null;
foreach ($logoSources as $source) {
    if (file_exists($source)) {
        $logoFile = $source;
        break;
    }
}

if ($logoFile) {
    echo "<div class='success'>✅ وُجد ملف اللوغو: $logoFile</div>";
    
    $brands = ['lenovo', 'dell', 'apple', 'hp', 'samsung'];
    foreach ($brands as $brand) {
        $destination = "public/storage/brands/$brand.jpg";
        if (copy($logoFile, $destination)) {
            echo "<div class='success'>✅ تم إنشاء: $brand.jpg</div>";
        } else {
            echo "<div class='error'>❌ فشل إنشاء: $brand.jpg</div>";
        }
    }
} else {
    echo "<div class='error'>❌ لم يتم العثور على ملف اللوغو</div>";
    
    // إنشاء صورة وهمية بسيطة
    $dummyImage = imagecreate(200, 200);
    $bgColor = imagecolorallocate($dummyImage, 240, 240, 240);
    $textColor = imagecolorallocate($dummyImage, 100, 100, 100);
    
    $brands = ['lenovo', 'dell', 'apple', 'hp', 'samsung'];
    foreach ($brands as $brand) {
        $destination = "public/storage/brands/$brand.jpg";
        imagestring($dummyImage, 5, 50, 90, strtoupper($brand), $textColor);
        if (imagejpeg($dummyImage, $destination)) {
            echo "<div class='success'>✅ تم إنشاء صورة وهمية: $brand.jpg</div>";
        }
    }
    imagedestroy($dummyImage);
}

// 4. تعيين الصلاحيات
echo "<h3>🔒 تعيين الصلاحيات:</h3>";
$permissionDirs = [
    'public/storage' => 0755,
    'public/storage/brands' => 0755,
    'public/storage/categories' => 0755,
    'public/storage/products' => 0755,
    'public/storage/images' => 0755
];

foreach ($permissionDirs as $dir => $perm) {
    if (is_dir($dir)) {
        if (chmod($dir, $perm)) {
            echo "<div class='success'>✅ صلاحيات $dir: " . decoct($perm) . "</div>";
        } else {
            echo "<div class='error'>❌ فشل تعيين صلاحيات $dir</div>";
        }
        
        // تعيين صلاحيات الملفات داخل المجلد
        $files = glob($dir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                chmod($file, 0644);
            }
        }
    }
}

// 5. اختبار الصور
echo "<h3>🧪 اختبار الصور:</h3>";
$testImages = [
    'Apple Brand' => '/storage/brands/apple.jpg',
    'Dell Brand' => '/storage/brands/dell.jpg',
    'HP Brand' => '/storage/brands/hp.jpg',
    'Lenovo Brand' => '/storage/brands/lenovo.jpg',
    'Samsung Brand' => '/storage/brands/samsung.jpg'
];

foreach ($testImages as $name => $url) {
    $fullPath = __DIR__ . '/public' . $url;
    if (file_exists($fullPath)) {
        $size = filesize($fullPath);
        echo "<div class='success'>✅ $name: <a href='$url' target='_blank'>$url</a> (حجم: $size بايت)</div>";
    } else {
        echo "<div class='error'>❌ $name: $url (غير موجود)</div>";
    }
}

// 6. معلومات إضافية
echo "<h3>📊 معلومات النظام:</h3>";
echo "<div class='info'>📁 المجلد الحالي: " . __DIR__ . "</div>";
echo "<div class='info'>🔒 المستخدم: " . get_current_user() . "</div>";
echo "<div class='info'>📊 مساحة القرص المتاحة: " . disk_free_space(__DIR__) . " بايت</div>";

// عرض محتويات المجلدات
echo "<h3>📂 محتويات المجلدات:</h3>";
$checkDirs = ['public/storage/brands', 'public/storage/images'];
foreach ($checkDirs as $dir) {
    if (is_dir($dir)) {
        $files = array_diff(scandir($dir), ['.', '..']);
        echo "<div class='info'>📁 $dir: " . count($files) . " ملف</div>";
        foreach ($files as $file) {
            echo "<div style='margin-left:20px;'>• $file</div>";
        }
    }
}

echo "<hr>";
echo "<div class='success'>🎉 تم الانتهاء من إصلاح الصور!</div>";
echo "<div class='info'>🔗 اختبر الآن: <a href='/' target='_blank'>الصفحة الرئيسية</a></div>";
echo "<div class='warning'>⚠️ احذف هذا الملف بعد التأكد من عمل الصور!</div>";
?> 
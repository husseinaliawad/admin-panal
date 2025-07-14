<?php
/**
 * إنشاء مجلدات الصور في public/storage مباشرة
 * بدون استخدام symlink
 */

echo "<h2>🔧 إنشاء مجلدات الصور - حل بدون symlink</h2>";
echo "<style>body{font-family:Arial;margin:40px;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";

// إنشاء المجلدات المطلوبة
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
            echo "<p class='success'>✅ تم إنشاء المجلد: $folder</p>";
        } else {
            echo "<p class='error'>❌ فشل في إنشاء المجلد: $folder</p>";
        }
    } else {
        echo "<p class='info'>📁 المجلد موجود: $folder</p>";
    }
}

// نسخ الصور من public/images- إلى public/storage/images
if (is_dir('public/images-')) {
    $files = glob('public/images-/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            $filename = basename($file);
            $destination = 'public/storage/images/' . $filename;
            if (copy($file, $destination)) {
                echo "<p class='success'>✅ تم نسخ: $filename</p>";
            }
        }
    }
} else {
    echo "<p class='error'>❌ مجلد public/images- غير موجود</p>";
}

// إنشاء صور العلامات التجارية (استخدام اللوغو)
if (file_exists('public/storage/images/logo.jpg')) {
    $brands = ['lenovo', 'dell', 'apple', 'hp', 'samsung'];
    foreach ($brands as $brand) {
        $destination = "public/storage/brands/$brand.jpg";
        if (copy('public/storage/images/logo.jpg', $destination)) {
            echo "<p class='success'>✅ تم إنشاء صورة العلامة التجارية: $brand.jpg</p>";
        }
    }
} else {
    echo "<p class='error'>❌ ملف logo.jpg غير موجود</p>";
}

// إنشاء صور الفئات
if (file_exists('public/storage/images/logo.jpg')) {
    $categories = ['laptops', 'gaming', 'computer-teile', 'gerate-reparieren'];
    foreach ($categories as $category) {
        $destination = "public/storage/categories/$category.jpg";
        if (copy('public/storage/images/logo.jpg', $destination)) {
            echo "<p class='success'>✅ تم إنشاء صورة الفئة: $category.jpg</p>";
        }
    }
}

// تعيين الصلاحيات
echo "<h3>🔒 تعيين الصلاحيات:</h3>";
chmod('public/storage', 0755);
chmod('public/storage/brands', 0755);
chmod('public/storage/categories', 0755);
chmod('public/storage/products', 0755);
chmod('public/storage/images', 0755);

echo "<p class='success'>✅ تم تعيين الصلاحيات</p>";

// اختبار الصور
echo "<h3>🧪 اختبار الصور:</h3>";
$testImages = [
    'Logo' => '/storage/images/logo.jpg',
    'Apple Brand' => '/storage/brands/apple.jpg',
    'Dell Brand' => '/storage/brands/dell.jpg',
    'HP Brand' => '/storage/brands/hp.jpg',
];

foreach ($testImages as $name => $url) {
    $fullPath = __DIR__ . '/public' . $url;
    if (file_exists($fullPath)) {
        echo "<p class='success'>✅ $name: <a href='$url' target='_blank'>$url</a></p>";
    } else {
        echo "<p class='error'>❌ $name: $url (File not found)</p>";
    }
}

echo "<hr>";
echo "<p class='info'>🎯 <strong>الخطوة التالية:</strong></p>";
echo "<p>1. اختبر الصور: <a href='/storage/brands/apple.jpg' target='_blank'>/storage/brands/apple.jpg</a></p>";
echo "<p>2. اختبر الموقع: <a href='/' target='_blank'>الصفحة الرئيسية</a></p>";
echo "<p>3. احذف هذا الملف بعد الانتهاء!</p>";
?> 
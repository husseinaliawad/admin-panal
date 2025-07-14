<?php
// إصلاح مسارات الصور وإعادة التوجيه
echo "<h2>🔧 إصلاح مسارات الصور</h2>";

// 1. إنشاء المجلدات
$directories = ['brands', 'categories', 'products'];
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "✅ تم إنشاء المجلد: $dir<br>";
    } else {
        echo "✅ المجلد موجود: $dir<br>";
    }
}

// 2. نسخ الصور من public/storage إلى المجلدات الجديدة
$sourceDirectories = [
    'storage/brands' => 'brands',
    'storage/categories' => 'categories', 
    'storage/products' => 'products'
];

echo "<hr><strong>نسخ الصور:</strong><br>";
foreach ($sourceDirectories as $source => $destination) {
    if (is_dir($source)) {
        $files = glob($source . '/*');
        foreach ($files as $file) {
            $filename = basename($file);
            $newPath = $destination . '/' . $filename;
            if (copy($file, $newPath)) {
                echo "✅ نُسخ: $filename إلى $destination<br>";
            }
        }
    } else {
        echo "⚠️ المجلد المصدر غير موجود: $source<br>";
    }
}

// 3. تحديث .htaccess
$htaccessRules = '
# قواعد إعادة التوجيه للصور
RewriteEngine On

# إعادة توجيه /public/categories/ إلى /categories/
RewriteRule ^public/categories/(.*)$ /categories/$1 [R=301,L]

# إعادة توجيه /public/brands/ إلى /brands/ 
RewriteRule ^public/brands/(.*)$ /brands/$1 [R=301,L]

# إعادة توجيه /public/products/ إلى /products/
RewriteRule ^public/products/(.*)$ /products/$1 [R=301,L]

# إعادة توجيه /storage/brands/ إلى /brands/
RewriteRule ^storage/brands/(.*)$ /brands/$1 [R=301,L]

# إعادة توجيه /storage/categories/ إلى /categories/
RewriteRule ^storage/categories/(.*)$ /categories/$1 [R=301,L]

# إعادة توجيه /storage/products/ إلى /products/
RewriteRule ^storage/products/(.*)$ /products/$1 [R=301,L]
';

// قراءة .htaccess الحالي
$currentHtaccess = '';
if (file_exists('.htaccess')) {
    $currentHtaccess = file_get_contents('.htaccess');
}

// التحقق من وجود القواعد
if (strpos($currentHtaccess, 'قواعد إعادة التوجيه للصور') === false) {
    $newHtaccess = $htaccessRules . "\n" . $currentHtaccess;
    if (file_put_contents('.htaccess', $newHtaccess)) {
        echo "<hr>✅ تم تحديث .htaccess بقواعد إعادة التوجيه<br>";
    } else {
        echo "<hr>❌ فشل في تحديث .htaccess<br>";
    }
} else {
    echo "<hr>✅ قواعد إعادة التوجيه موجودة في .htaccess<br>";
}

// 4. اختبار المسارات
echo "<hr><strong>اختبار المسارات:</strong><br>";
$testPaths = [
    '/categories/' => 'المسار الصحيح للفئات',
    '/brands/' => 'المسار الصحيح للعلامات التجارية', 
    '/products/' => 'المسار الصحيح للمنتجات'
];

foreach ($testPaths as $path => $description) {
    $fullUrl = 'https://' . $_SERVER['HTTP_HOST'] . $path;
    echo "<a href='$fullUrl' target='_blank'>$fullUrl</a> - $description<br>";
}

echo "<hr>";
echo "<strong>✅ تم الانتهاء من إصلاح مسارات الصور!</strong><br>";
echo "الآن استخدم المسارات الصحيحة بدون /public/<br>";
?> 
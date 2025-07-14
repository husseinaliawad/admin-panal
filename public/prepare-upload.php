<?php
/**
 * 📦 تحضير الملفات للرفع للخادم
 * هذه الأداة تنسخ الملفات المحدثة إلى مجلد منفصل للرفع
 */

echo "<h1>📦 تحضير الملفات للرفع</h1>";
echo "<style>
body{font-family:Arial;margin:40px;} 
.success{color:green;} 
.error{color:red;} 
.info{color:blue;}
.warning{color:orange;}
.file-section{background:#f5f5f5;padding:20px;border-radius:8px;margin:20px 0;}
</style>";

// تحديد المسار الصحيح (نحن الآن في مجلد public)
$basePath = dirname(__DIR__); // مجلد المشروع الجذر
$publicPath = __DIR__; // مجلد public

// إنشاء مجلد للرفع
$uploadDir = $publicPath . '/upload-ready';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
    echo "<div class='info'>📁 تم إنشاء مجلد: upload-ready</div>";
}

// قائمة الملفات المحدثة
$files = [
    'public/.htaccess',
    'config/filesystems.php',
    'app/Filament/Resources/BrandsResource.php',
    'app/Filament/Resources/CategoryResource.php', 
    'app/Filament/Resources/ProductResource.php',
    'app/Helpers/ImageHelper.php'
];

echo "<div class='file-section'>";
echo "<h2>📋 نسخ الملفات المحدثة</h2>";

foreach ($files as $file) {
    $fullPath = $basePath . '/' . $file;
    if (file_exists($fullPath)) {
        // إنشاء مسار الوجهة
        $destination = $uploadDir . '/' . $file;
        $destDir = dirname($destination);
        
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }
        
        // نسخ الملف
        if (copy($fullPath, $destination)) {
            echo "<div class='success'>✅ تم نسخ: $file</div>";
        } else {
            echo "<div class='error'>❌ فشل نسخ: $file</div>";
        }
    } else {
        echo "<div class='error'>❌ ملف غير موجود: $file</div>";
    }
}
echo "</div>";

// إنشاء مجلدات الصور
echo "<div class='file-section'>";
echo "<h2>📁 إنشاء مجلدات الصور</h2>";
$imageFolders = ['brands', 'categories', 'products', 'images-'];

foreach ($imageFolders as $folder) {
    $sourceDir = $publicPath . '/' . $folder;
    $destDir = $uploadDir . '/public/' . $folder;
    
    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
        echo "<div class='info'>📁 تم إنشاء مجلد: public/$folder</div>";
    }
    
    // نسخ الصور الموجودة
    if (is_dir($sourceDir)) {
        $files = array_diff(scandir($sourceDir), ['.', '..']);
        foreach ($files as $file) {
            if (is_file("$sourceDir/$file")) {
                copy("$sourceDir/$file", "$destDir/$file");
                echo "<div class='success'>📸 تم نسخ صورة: $folder/$file</div>";
            }
        }
    }
}
echo "</div>";

// إنشاء ملف التعليمات
echo "<div class='file-section'>";
echo "<h2>📝 إنشاء ملف التعليمات</h2>";
$instructions = "
# 📦 تعليمات الرفع للخادم

## الملفات المحدثة:
- public/.htaccess (قواعد إعادة التوجيه)
- config/filesystems.php (إعدادات الأقراص)
- app/Filament/Resources/ (موارد Filament)
- app/Helpers/ImageHelper.php (مساعد الصور)

## المجلدات المطلوبة:
- public/brands/
- public/categories/
- public/products/
- public/images-/

## خطوات الرفع:
1. ارفع جميع الملفات في مجلد upload-ready
2. تأكد من أن المجلدات لها صلاحيات 755
3. اختبر الروابط:
   - https://yoursite.com/brands/
   - https://yoursite.com/categories/
   - https://yoursite.com/products/

## اختبار إعادة التوجيه:
- https://yoursite.com/public/categories/ → https://yoursite.com/categories/
- https://yoursite.com/storage/brands/ → https://yoursite.com/brands/

## ملاحظات:
- احذف test-images-final.php بعد الاختبار
- احذف prepare-upload.php بعد الرفع
- احذف upload-ready/ بعد الانتهاء
";

file_put_contents("$uploadDir/UPLOAD_INSTRUCTIONS.md", $instructions);
echo "<div class='success'>✅ تم إنشاء ملف التعليمات</div>";
echo "</div>";

// عرض الملخص
echo "<div class='file-section'>";
echo "<h2>📊 ملخص الملفات المحضرة</h2>";
$totalSize = 0;
$fileCount = 0;

function getDirSize($dir) {
    global $totalSize, $fileCount;
    if (!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                getDirSize($path);
            } else {
                $totalSize += filesize($path);
                $fileCount++;
            }
        }
    }
}

getDirSize($uploadDir);
echo "<div class='info'>📊 إجمالي الملفات: $fileCount</div>";
echo "<div class='info'>📊 إجمالي الحجم: " . round($totalSize/1024, 2) . " KB</div>";
echo "</div>";

echo "<div class='file-section'>";
echo "<h2>🚀 الخطوات التالية</h2>";
echo "<ol>";
echo "<li>اختبر النظام محلياً باستخدام <a href='test-images-final.php'>test-images-final.php</a></li>";
echo "<li>ارفع محتوى مجلد upload-ready للخادم</li>";
echo "<li>اختبر الروابط في الخادم</li>";
echo "<li>احذف الملفات المؤقتة</li>";
echo "</ol>";
echo "</div>";

?> 
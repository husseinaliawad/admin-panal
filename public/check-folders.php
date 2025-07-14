<?php
// التحقق من وجود مجلدات الصور وإنشاؤها
echo "<h2>📁 فحص وإنشاء مجلدات الصور</h2>";

// المجلدات المطلوبة
$directories = ['brands', 'categories', 'products'];

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        echo "✅ المجلد موجود: $dir<br>";
    } else {
        if (mkdir($dir, 0755, true)) {
            echo "✅ تم إنشاء المجلد: $dir<br>";
        } else {
            echo "❌ فشل إنشاء المجلد: $dir<br>";
        }
    }
}

// معلومات الخادم
echo "<hr>";
echo "<strong>معلومات الخادم:</strong><br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Current Directory: " . getcwd() . "<br>";
echo "PHP Version: " . phpversion() . "<br>";

// اختبار الصور
echo "<hr>";
echo "<strong>اختبار الصور:</strong><br>";
$testImages = ['brands/apple.jpg', 'categories/test.jpg'];
foreach ($testImages as $img) {
    if (file_exists($img)) {
        echo "✅ $img موجود<br>";
    } else {
        echo "❌ $img غير موجود<br>";
    }
}
?> 
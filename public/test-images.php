<?php
/**
 * ملف اختبار الصور - للتأكد من عمل المسارات الجديدة
 */
echo "<h2>🖼️ اختبار الصور - الحل النهائي</h2>";
echo "<style>
body{font-family:Arial;margin:40px;background:#f8f9fa;} 
.success{color:#28a745;background:#d4edda;padding:10px;border-radius:5px;margin:10px 0;} 
.error{color:#dc3545;background:#f8d7da;padding:10px;border-radius:5px;margin:10px 0;} 
.info{color:#17a2b8;background:#d1ecf1;padding:10px;border-radius:5px;margin:10px 0;}
.image-test{display:inline-block;margin:10px;padding:10px;border:1px solid #ddd;border-radius:5px;text-align:center;}
.image-test img{max-width:150px;max-height:150px;border-radius:5px;}
</style>";

// اختبار الصور
echo "<h3>📱 اختبار صور العلامات التجارية:</h3>";

$brandImages = [
    'Apple' => 'apple.jpg',
    'Samsung' => 'samsung.jpg', 
    'Dell' => 'dell.jpg',
    'HP' => 'hp.jpg',
    'Lenovo' => 'lenovo.jpg'
];

echo "<div>";
foreach ($brandImages as $brand => $image) {
    $directPath = "/brands/$image";
    $storagePath = "/storage/brands/$image";
    
    echo "<div class='image-test'>";
    echo "<h4>$brand</h4>";
    
    // اختبار المسار المباشر
    if (file_exists(__DIR__ . $directPath)) {
        echo "<p class='success'>✅ المسار المباشر يعمل</p>";
        echo "<img src='$directPath' alt='$brand' title='Direct Path: $directPath'>";
    } else {
        echo "<p class='error'>❌ المسار المباشر لا يعمل</p>";
    }
    
    echo "<br><small>المسار: $directPath</small>";
    echo "<br><small>مسار التخزين: $storagePath</small>";
    echo "</div>";
}
echo "</div>";

// معلومات الخادم
echo "<h3>🔧 معلومات الخادم:</h3>";
echo "<div class='info'>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Script Name:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p><strong>Current Directory:</strong> " . __DIR__ . "</p>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "</div>";

// اختبار المجلدات
echo "<h3>📁 اختبار المجلدات:</h3>";
$testDirs = [
    'brands' => __DIR__ . '/brands',
    'categories' => __DIR__ . '/categories', 
    'products' => __DIR__ . '/products',
    'images-' => __DIR__ . '/images-'
];

foreach ($testDirs as $name => $path) {
    if (is_dir($path)) {
        $files = array_diff(scandir($path), ['.', '..']);
        echo "<div class='success'>✅ مجلد $name موجود (" . count($files) . " ملف)</div>";
    } else {
        echo "<div class='error'>❌ مجلد $name غير موجود</div>";
    }
}

echo "<hr>";
echo "<div class='info'>🎯 <strong>خطوات الاختبار:</strong></div>";
echo "<ol>";
echo "<li>تأكد من أن الصور تظهر أعلاه</li>";
echo "<li>اختبر الرابط: <a href='/' target='_blank'>الصفحة الرئيسية</a></li>";
echo "<li>ابحث عن قسم 'Browse Popular Brands'</li>";
echo "<li>تأكد من ظهور صور العلامات التجارية</li>";
echo "<li>احذف هذا الملف بعد الاختبار!</li>";
echo "</ol>";
?> 
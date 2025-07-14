<?php
/**
 * فحص نهائي للتأكد من أن كل شيء يعمل بشكل صحيح
 */
echo "<h2>✅ فحص نهائي - حل مشكلة الصور</h2>";
echo "<style>
body{font-family:Arial;margin:40px;background:#f8f9fa;} 
.success{color:#28a745;background:#d4edda;padding:10px;border-radius:5px;margin:10px 0;} 
.error{color:#dc3545;background:#f8d7da;padding:10px;border-radius:5px;margin:10px 0;} 
.info{color:#17a2b8;background:#d1ecf1;padding:10px;border-radius:5px;margin:10px 0;}
.warning{color:#856404;background:#fff3cd;padding:10px;border-radius:5px;margin:10px 0;}
.btn{background:#007cba;color:white;padding:10px 20px;border:none;border-radius:4px;cursor:pointer;text-decoration:none;display:inline-block;margin:10px 0;}
.btn:hover{background:#005a8b;}
.status-good{color:#28a745;} .status-bad{color:#dc3545;}
</style>";

$checks = [];

// فحص المجلدات
echo "<h3>📁 فحص المجلدات:</h3>";
$directories = ['brands', 'categories', 'products', 'images-'];
foreach ($directories as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (is_dir($path)) {
        $files = array_diff(scandir($path), ['.', '..']);
        $count = count($files);
        echo "<div class='success'>✅ $dir: $count ملف</div>";
        $checks['directories'][$dir] = true;
    } else {
        echo "<div class='error'>❌ $dir: غير موجود</div>";
        $checks['directories'][$dir] = false;
    }
}

// فحص صور العلامات التجارية
echo "<h3>🏷️ فحص صور العلامات التجارية:</h3>";
$brandImages = ['apple.jpg', 'samsung.jpg', 'dell.jpg', 'hp.jpg', 'lenovo.jpg'];
$brandImagesFound = 0;
foreach ($brandImages as $image) {
    $path = __DIR__ . '/brands/' . $image;
    if (file_exists($path)) {
        $size = round(filesize($path) / 1024, 2);
        echo "<div class='success'>✅ $image: {$size} KB</div>";
        $brandImagesFound++;
    } else {
        echo "<div class='error'>❌ $image: غير موجود</div>";
    }
}
$checks['brand_images'] = $brandImagesFound;

// فحص ملف .htaccess
echo "<h3>⚙️ فحص ملف .htaccess:</h3>";
$htaccessPath = __DIR__ . '/.htaccess';
if (file_exists($htaccessPath)) {
    $content = file_get_contents($htaccessPath);
    if (strpos($content, 'RewriteRule ^storage/brands/(.*)$ brands/$1 [L]') !== false) {
        echo "<div class='success'>✅ قواعد إعادة التوجيه موجودة</div>";
        $checks['htaccess'] = true;
    } else {
        echo "<div class='error'>❌ قواعد إعادة التوجيه غير موجودة</div>";
        $checks['htaccess'] = false;
    }
} else {
    echo "<div class='error'>❌ ملف .htaccess غير موجود</div>";
    $checks['htaccess'] = false;
}

// فحص ImageHelper
echo "<h3>🖼️ فحص ImageHelper:</h3>";
$imageHelperPath = __DIR__ . '/../app/Helpers/ImageHelper.php';
if (file_exists($imageHelperPath)) {
    $content = file_get_contents($imageHelperPath);
    if (strpos($content, 'getBrandImage') !== false) {
        echo "<div class='success'>✅ ImageHelper موجود ومحدث</div>";
        $checks['image_helper'] = true;
    } else {
        echo "<div class='warning'>⚠️ ImageHelper موجود لكن قد يحتاج تحديث</div>";
        $checks['image_helper'] = false;
    }
} else {
    echo "<div class='error'>❌ ImageHelper غير موجود</div>";
    $checks['image_helper'] = false;
}

// حساب النتيجة الإجمالية
echo "<h3>📊 النتيجة الإجمالية:</h3>";
$totalChecks = 0;
$passedChecks = 0;

// فحص المجلدات
foreach ($checks['directories'] as $result) {
    $totalChecks++;
    if ($result) $passedChecks++;
}

// فحص صور العلامات التجارية
$totalChecks++;
if ($checks['brand_images'] >= 4) $passedChecks++; // على الأقل 4 من 5 صور

// فحص htaccess
$totalChecks++;
if ($checks['htaccess']) $passedChecks++;

// فحص ImageHelper
$totalChecks++;
if ($checks['image_helper']) $passedChecks++;

$percentage = round(($passedChecks / $totalChecks) * 100);

if ($percentage >= 80) {
    echo "<div class='success'>";
    echo "🎉 <strong>ممتاز!</strong> النظام يعمل بشكل صحيح ($percentage%)";
    echo "</div>";
} elseif ($percentage >= 60) {
    echo "<div class='warning'>";
    echo "⚠️ <strong>جيد</strong> لكن يحتاج بعض التحسينات ($percentage%)";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "❌ <strong>يحتاج إصلاح</strong> - هناك مشاكل عديدة ($percentage%)";
    echo "</div>";
}

echo "<h3>📋 خطوات ما بعد التحقق:</h3>";
echo "<ol>";
echo "<li>📤 ارفع الملفات إلى الخادم</li>";
echo "<li>🌐 اختبر الموقع: <a href='/' target='_blank'>الصفحة الرئيسية</a></li>";
echo "<li>🔄 شغل: <a href='update-brand-paths.php' target='_blank'>update-brand-paths.php</a></li>";
echo "<li>🖼️ اختبر: <a href='test-images.php' target='_blank'>test-images.php</a></li>";
echo "<li>🧹 نظف: <a href='cleanup-test-files.php' target='_blank'>cleanup-test-files.php</a></li>";
echo "</ol>";

echo "<div class='info'>";
echo "🎯 <strong>مسارات الاختبار:</strong><br>";
echo "المسار المباشر: <code>https://yourdomain.com/brands/apple.jpg</code><br>";
echo "المسار عبر storage: <code>https://yourdomain.com/storage/brands/apple.jpg</code><br>";
echo "كلا المسارين يجب أن يعمل!";
echo "</div>";
?> 
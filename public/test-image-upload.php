<?php
/**
 * اختبار رفع الصور ونظام المسارات الجديد
 */

echo "<h2>🧪 اختبار نظام رفع الصور</h2>";
echo "<style>
body{font-family:Arial;margin:40px;direction:rtl;} 
.success{color:green;} 
.error{color:red;} 
.info{color:blue;}
img{max-width:150px;margin:10px;border:1px solid #ddd;border-radius:5px;}
</style>";

// التحقق من المجلدات
$directories = ['public/brands', 'public/categories', 'public/products'];
foreach ($directories as $dir) {
    if (is_dir($dir)) {
        echo "<div class='success'>✅ المجلد موجود: $dir</div>";
    } else {
        mkdir($dir, 0755, true);
        echo "<div class='info'>📁 تم إنشاء المجلد: $dir</div>";
    }
}

// التحقق من الصور الموجودة
echo "<h3>📸 الصور الموجودة:</h3>";

foreach ($directories as $dir) {
    $folder = basename($dir);
    echo "<h4>$folder:</h4>";
    
    if (is_dir($dir)) {
        $files = array_diff(scandir($dir), ['.', '..']);
        if (!empty($files)) {
            echo "<div style='display:flex;flex-wrap:wrap;'>";
            foreach ($files as $file) {
                $imagePath = "$folder/$file";
                $fullPath = "$dir/$file";
                $fileSize = filesize($fullPath);
                echo "<div style='margin:10px;text-align:center;'>";
                echo "<img src='/$imagePath' alt='$file' onerror='this.style.display=\"none\"'>";
                echo "<br><small>$file</small>";
                echo "<br><small>(" . round($fileSize/1024, 2) . " KB)</small>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>لا توجد صور في هذا المجلد</p>";
        }
    }
}

// اختبار وجود قاعدة البيانات
echo "<h3>📊 اختبار قاعدة البيانات:</h3>";
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=admin_panel", "root", "");
    echo "<div class='success'>✅ الاتصال بقاعدة البيانات نجح</div>";
    
    // عرض العلامات التجارية
    $brands = $pdo->query("SELECT id, name, image FROM brands WHERE is_active = 1")->fetchAll(PDO::FETCH_ASSOC);
    echo "<h4>العلامات التجارية:</h4>";
    if (!empty($brands)) {
        echo "<div style='display:flex;flex-wrap:wrap;'>";
        foreach ($brands as $brand) {
            $imagePath = $brand['image'];
            if ($imagePath && !str_starts_with($imagePath, 'brands/')) {
                $imagePath = 'brands/' . $imagePath;
            }
            echo "<div style='margin:10px;text-align:center;border:1px solid #ddd;padding:10px;'>";
            echo "<img src='/$imagePath' alt='{$brand['name']}' onerror='this.src=\"/images-/logo.jpg\"'>";
            echo "<br><strong>{$brand['name']}</strong>";
            echo "<br><small>DB: {$brand['image']}</small>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>لا توجد علامات تجارية نشطة</p>";
    }
    
} catch(PDOException $e) {
    echo "<div class='error'>❌ خطأ في قاعدة البيانات: " . $e->getMessage() . "</div>";
}

// اختبار ImageHelper
echo "<h3>🔧 اختبار ImageHelper:</h3>";
require_once __DIR__ . '/../app/Helpers/ImageHelper.php';

$testPaths = [
    'apple.jpg',
    'brands/apple.jpg',
    '/brands/apple.jpg',
    'samsung.jpg'
];

foreach ($testPaths as $testPath) {
    $result = \App\Helpers\ImageHelper::getImageUrl($testPath);
    echo "<div>Input: '$testPath' → Output: '$result'</div>";
}

?>

<hr>
<div class="info">
    <h3>🎯 نصائح للاستخدام:</h3>
    <ul>
        <li>الصور الآن تُحفظ مباشرة في public/brands/, public/categories/, public/products/</li>
        <li>لا حاجة لـ symlink أو storage:link</li>
        <li>يمكن الوصول للصور مباشرة عبر: /brands/filename.jpg</li>
        <li>ImageHelper يتعامل مع المسارات تلقائياً</li>
    </ul>
    
    <p><strong>⚠️ احذف هذا الملف بعد الاختبار!</strong></p>
</div> 
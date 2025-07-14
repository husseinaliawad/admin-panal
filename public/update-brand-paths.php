<?php
/**
 * تحديث مسارات صور العلامات التجارية في قاعدة البيانات
 */
echo "<h2>🔄 تحديث مسارات العلامات التجارية</h2>";
echo "<style>
body{font-family:Arial;margin:40px;background:#f8f9fa;} 
.success{color:#28a745;background:#d4edda;padding:10px;border-radius:5px;margin:10px 0;} 
.error{color:#dc3545;background:#f8d7da;padding:10px;border-radius:5px;margin:10px 0;} 
.info{color:#17a2b8;background:#d1ecf1;padding:10px;border-radius:5px;margin:10px 0;}
.btn{background:#007cba;color:white;padding:10px 20px;border:none;border-radius:4px;cursor:pointer;text-decoration:none;display:inline-block;margin:10px 0;}
.btn:hover{background:#005a8b;}
</style>";

// تضمين إعدادات Laravel
require_once __DIR__ . '/../vendor/autoload.php';

try {
    // تحميل إعدادات Laravel
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    // الحصول على اتصال قاعدة البيانات
    $brands = DB::table('brands')->get();
    
    echo "<h3>📊 العلامات التجارية الحالية:</h3>";
    echo "<table border='1' style='border-collapse:collapse;width:100%;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Current Image</th><th>New Image</th></tr>";
    
    foreach ($brands as $brand) {
        $newImagePath = 'brands/' . strtolower($brand->name) . '.jpg';
        
        echo "<tr>";
        echo "<td>{$brand->id}</td>";
        echo "<td>{$brand->name}</td>";
        echo "<td>" . ($brand->image ?: 'NULL') . "</td>";
        echo "<td>{$newImagePath}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // تحديث المسارات
    if (isset($_POST['update_paths'])) {
        echo "<h3>🔄 تحديث المسارات...</h3>";
        
        $brandPaths = [
            'Apple' => 'brands/apple.jpg',
            'Samsung' => 'brands/samsung.jpg',
            'Dell' => 'brands/dell.jpg',
            'HP' => 'brands/hp.jpg',
            'Lenovo' => 'brands/lenovo.jpg'
        ];
        
        foreach ($brandPaths as $brandName => $imagePath) {
            $updated = DB::table('brands')
                ->where('name', $brandName)
                ->update(['image' => $imagePath]);
            
            if ($updated) {
                echo "<div class='success'>✅ تم تحديث {$brandName}: {$imagePath}</div>";
            } else {
                echo "<div class='error'>❌ لم يتم العثور على {$brandName} في قاعدة البيانات</div>";
            }
        }
        
        echo "<div class='info'>✅ تم تحديث جميع المسارات!</div>";
        echo "<a href='/test-images.php' class='btn'>🖼️ اختبار الصور</a>";
        echo "<a href='/' class='btn'>🏠 الصفحة الرئيسية</a>";
    } else {
        echo "<form method='POST'>";
        echo "<div class='info'>📝 هل تريد تحديث مسارات الصور في قاعدة البيانات؟</div>";
        echo "<button type='submit' name='update_paths' class='btn'>🔄 تحديث المسارات</button>";
        echo "</form>";
    }
    
} catch (Exception $e) {
    echo "<div class='error'>❌ خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage() . "</div>";
    echo "<div class='info'>💡 تأكد من أن ملف .env محدث بإعدادات قاعدة البيانات الصحيحة</div>";
}

echo "<hr>";
echo "<div class='info'>🎯 <strong>خطوات ما بعد التحديث:</strong></div>";
echo "<ol>";
echo "<li>تشغيل هذا الملف لتحديث قاعدة البيانات</li>";
echo "<li>اختبار الصور من خلال test-images.php</li>";
echo "<li>زيارة الصفحة الرئيسية للتأكد من ظهور الصور</li>";
echo "<li>حذف ملفات الاختبار بعد التأكد من العمل</li>";
echo "</ol>";
?> 
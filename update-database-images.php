<?php
/**
 * تحديث قاعدة البيانات مع مسارات الصور الجديدة
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// إعداد قاعدة البيانات
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/database.sqlite',
    'prefix' => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

echo "<h2>📊 تحديث قاعدة البيانات - مسارات الصور</h2>";
echo "<style>body{font-family:Arial;margin:40px;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";

try {
    // تحديث صور العلامات التجارية
    echo "<h3>🏷️ تحديث صور العلامات التجارية:</h3>";
    
    $brands = [
        ['name' => 'Lenovo', 'image' => 'brands/lenovo.jpg'],
        ['name' => 'Dell', 'image' => 'brands/dell.jpg'],
        ['name' => 'Apple', 'image' => 'brands/apple.jpg'],
        ['name' => 'HP', 'image' => 'brands/hp.jpg'],
        ['name' => 'Samsung', 'image' => 'brands/samsung.jpg'],
    ];
    
    foreach ($brands as $brand) {
        $updated = Capsule::table('brands')
            ->where('name', $brand['name'])
            ->update(['image' => $brand['image']]);
        
        if ($updated) {
            echo "<p class='success'>✅ تم تحديث {$brand['name']}: {$brand['image']}</p>";
        } else {
            echo "<p class='error'>❌ فشل تحديث {$brand['name']}</p>";
        }
    }
    
    // تحديث صور الفئات
    echo "<h3>📱 تحديث صور الفئات:</h3>";
    
    $categories = [
        ['name' => 'Laptops', 'image' => 'categories/laptops.jpg'],
        ['name' => 'Gaming', 'image' => 'categories/gaming.jpg'],
        ['name' => 'Computer Teile', 'image' => 'categories/computer-teile.jpg'],
        ['name' => 'Geräte reparieren', 'image' => 'categories/gerate-reparieren.jpg'],
    ];
    
    foreach ($categories as $category) {
        $updated = Capsule::table('categories')
            ->where('name', $category['name'])
            ->update(['image' => $category['image']]);
        
        if ($updated) {
            echo "<p class='success'>✅ تم تحديث {$category['name']}: {$category['image']}</p>";
        } else {
            echo "<p class='error'>❌ فشل تحديث {$category['name']}</p>";
        }
    }
    
    // عرض النتائج
    echo "<h3>📊 ملخص قاعدة البيانات:</h3>";
    
    $allBrands = Capsule::table('brands')->get();
    echo "<h4>العلامات التجارية:</h4>";
    foreach ($allBrands as $brand) {
        echo "<p class='info'>• {$brand->name}: {$brand->image}</p>";
    }
    
    $allCategories = Capsule::table('categories')->get();
    echo "<h4>الفئات:</h4>";
    foreach ($allCategories as $category) {
        echo "<p class='info'>• {$category->name}: {$category->image}</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ خطأ في قاعدة البيانات: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p class='success'>✅ تم تحديث قاعدة البيانات بنجاح!</p>";
echo "<p class='info'>🎯 الآن يمكنك اختبار الصور على الموقع</p>";
?> 
<?php

require_once 'vendor/autoload.php';

use App\Models\Brand;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🗃️ إضافة العلامات التجارية المفقودة...\n";

$brands = [
    ['name' => 'Lenovo', 'slug' => 'lenovo', 'image' => 'brands/lenovo.jpg', 'is_active' => true],
    ['name' => 'Dell', 'slug' => 'dell', 'image' => 'brands/dell.jpg', 'is_active' => true],
    ['name' => 'HP', 'slug' => 'hp', 'image' => 'brands/hp.jpg', 'is_active' => true],
];

foreach ($brands as $brandData) {
    try {
        $brand = Brand::where('slug', $brandData['slug'])->first();
        if ($brand) {
            $brand->update($brandData);
            echo "✅ تم تحديث العلامة التجارية: " . $brandData['name'] . "\n";
        } else {
            Brand::create($brandData);
            echo "✅ تم إضافة العلامة التجارية: " . $brandData['name'] . "\n";
        }
    } catch (Exception $e) {
        echo "❌ خطأ في إضافة " . $brandData['name'] . ": " . $e->getMessage() . "\n";
    }
}

echo "\n🎉 تم الانتهاء من إضافة العلامات التجارية!\n";
echo "🔍 العلامات التجارية الحالية في قاعدة البيانات:\n";

$allBrands = Brand::all(['name', 'image']);
foreach ($allBrands as $brand) {
    echo "- {$brand->name}: {$brand->image}\n";
} 
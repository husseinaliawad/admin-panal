#!/bin/bash

echo "🔧 إصلاح مشكلة صور العلامات التجارية"
echo "=================================="

# إنشاء مجلد العلامات التجارية
mkdir -p storage/app/public/brands

# نسخ الصور المتاحة لإنشاء صور العلامات التجارية
echo "📸 إنشاء صور العلامات التجارية..."

# استخدام الصور المتاحة
if [ -f "public/images-/card1.jpeg" ]; then
    cp public/images-/card1.jpeg storage/app/public/brands/apple.jpg
    echo "✅ تم إنشاء صورة Apple"
fi

if [ -f "public/images-/card1.jpeg" ]; then
    cp public/images-/card1.jpeg storage/app/public/brands/samsung.jpg
    echo "✅ تم إنشاء صورة Samsung"
fi

# إضافة المزيد من العلامات التجارية باستخدام صور مختلفة
if [ -f "public/images-/logo.jpg" ]; then
    cp public/images-/logo.jpg storage/app/public/brands/lenovo.jpg
    echo "✅ تم إنشاء صورة Lenovo"
fi

if [ -f "public/images-/logo.jpg" ]; then
    cp public/images-/logo.jpg storage/app/public/brands/dell.jpg
    echo "✅ تم إنشاء صورة Dell"
fi

if [ -f "public/images-/logo.jpg" ]; then
    cp public/images-/logo.jpg storage/app/public/brands/hp.jpg
    echo "✅ تم إنشاء صورة HP"
fi

# إضافة العلامات التجارية المفقودة إلى قاعدة البيانات
echo "🗃️ إضافة العلامات التجارية إلى قاعدة البيانات..."
php artisan tinker << 'EOF'
use App\Models\Brand;

// إضافة العلامات التجارية المفقودة
$brands = [
    ['name' => 'Lenovo', 'slug' => 'lenovo', 'image' => 'brands/lenovo.jpg'],
    ['name' => 'Dell', 'slug' => 'dell', 'image' => 'brands/dell.jpg'],
    ['name' => 'HP', 'slug' => 'hp', 'image' => 'brands/hp.jpg'],
];

foreach ($brands as $brandData) {
    Brand::updateOrCreate(
        ['slug' => $brandData['slug']],
        $brandData
    );
    echo "✅ تم إضافة/تحديث العلامة التجارية: " . $brandData['name'] . PHP_EOL;
}

echo "🎉 تم إضافة جميع العلامات التجارية بنجاح!" . PHP_EOL;
exit
EOF

# إنشاء رابط التخزين
echo "🔗 إنشاء رابط التخزين..."
php artisan storage:link

# تنظيف الذاكرة المؤقتة
echo "🧹 تنظيف الذاكرة المؤقتة..."
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo "🎉 تم إصلاح مشكلة صور العلامات التجارية بنجاح!"
echo "تحقق من الموقع الآن: https://completitcompservice.de" 
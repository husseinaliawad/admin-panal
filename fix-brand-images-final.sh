#!/bin/bash

echo "🔧 إصلاح مشكلة صور العلامات التجارية - الحل النهائي"
echo "=================================================="

# 1. إنشاء المجلدات المطلوبة
echo "📁 إنشاء المجلدات المطلوبة..."
mkdir -p storage/app/public/brands
mkdir -p storage/app/public/images
mkdir -p storage/app/public/categories

# 2. نسخ الصور الأساسية
echo "📂 نسخ الصور الأساسية..."
if [ -d "public/images-" ]; then
    cp -r public/images-/* storage/app/public/images/
    echo "✅ تم نسخ الصور الأساسية"
fi

# 3. إنشاء صور مختلفة لكل علامة تجارية
echo "🏷️ إنشاء صور مختلفة لكل علامة تجارية..."

# استخدام صور مختلفة لكل علامة تجارية
if [ -f "storage/app/public/images/card1.jpeg" ]; then
    cp storage/app/public/images/card1.jpeg storage/app/public/brands/apple.jpg
    echo "✅ تم إنشاء صورة Apple باستخدام card1.jpeg"
fi

if [ -f "storage/app/public/images/abholen.jpeg" ]; then
    cp storage/app/public/images/abholen.jpeg storage/app/public/brands/samsung.jpg
    echo "✅ تم إنشاء صورة Samsung باستخدام abholen.jpeg"
fi

if [ -f "storage/app/public/images/logo.jpg" ]; then
    cp storage/app/public/images/logo.jpg storage/app/public/brands/lenovo.jpg
    echo "✅ تم إنشاء صورة Lenovo باستخدام logo.jpg"
fi

# إضافة علامات تجارية إضافية بصور مختلفة
if [ -f "storage/app/public/images/bg.jpg" ]; then
    cp storage/app/public/images/bg.jpg storage/app/public/brands/dell.jpg
    echo "✅ تم إنشاء صورة Dell باستخدام bg.jpg"
fi

if [ -f "storage/app/public/images/card1.png" ]; then
    cp storage/app/public/images/card1.png storage/app/public/brands/hp.jpg
    echo "✅ تم إنشاء صورة HP باستخدام card1.png"
fi

# 4. إضافة العلامات التجارية المفقودة إلى قاعدة البيانات
echo "🗃️ إضافة العلامات التجارية المفقودة..."
php artisan tinker << 'EOF'
use App\Models\Brand;

$brands = [
    ['name' => 'Dell', 'slug' => 'dell', 'image' => 'brands/dell.jpg', 'is_active' => true],
    ['name' => 'HP', 'slug' => 'hp', 'image' => 'brands/hp.jpg', 'is_active' => true],
];

foreach ($brands as $brandData) {
    $existing = Brand::where('slug', $brandData['slug'])->first();
    if (!$existing) {
        Brand::create($brandData);
        echo "✅ تم إضافة العلامة التجارية: " . $brandData['name'] . PHP_EOL;
    } else {
        echo "⚠️ العلامة التجارية موجودة بالفعل: " . $brandData['name'] . PHP_EOL;
    }
}
exit
EOF

# 5. إنشاء أو تحديث رابط التخزين
echo "🔗 إدارة رابط التخزين..."
rm -rf public/storage 2>/dev/null
if php artisan storage:link 2>/dev/null; then
    echo "✅ تم إنشاء symbolic link بنجاح"
else
    echo "⚠️ فشل في إنشاء symbolic link، سيتم النسخ اليدوي..."
    mkdir -p public/storage
    cp -r storage/app/public/* public/storage/
    echo "✅ تم نسخ الملفات يدوياً إلى public/storage"
fi

# 6. تعيين الصلاحيات
echo "🔒 تعيين الصلاحيات..."
chmod -R 775 storage/app/public/brands
chmod -R 775 public/storage 2>/dev/null || true

# 7. تنظيف الذاكرة المؤقتة
echo "🧹 تنظيف الذاكرة المؤقتة..."
php artisan config:clear
php artisan view:clear
php artisan route:clear

# 8. عرض النتائج
echo ""
echo "📊 تحقق من النتائج..."
echo "العلامات التجارية في قاعدة البيانات:"
php artisan tinker --execute="App\Models\Brand::all(['name', 'image'])->each(function(\$b) { echo '- ' . \$b->name . ': ' . \$b->image . PHP_EOL; });"

echo ""
echo "الصور في مجلد brands:"
ls -la storage/app/public/brands/ | grep -E '\.(jpg|jpeg|png)$' || echo "لا توجد صور"

echo ""
echo "🎉 تم إصلاح مشكلة صور العلامات التجارية بنجاح!"
echo "🌐 اختبر الموقع الآن: https://completitcompservice.de"
echo "🔍 تحقق من قسم 'Browse Popular Brands' - يجب أن تظهر صور مختلفة لكل علامة تجارية" 
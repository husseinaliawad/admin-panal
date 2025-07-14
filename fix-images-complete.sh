#!/bin/bash

echo "🔧 إصلاح مشكلة الصور - Laravel CICS"
echo "================================="

# 1. إنشاء المجلدات المطلوبة
echo "📁 إنشاء المجلدات المطلوبة..."
mkdir -p storage/app/public/images
mkdir -p storage/app/public/brands
mkdir -p storage/app/public/categories
mkdir -p storage/app/public/products

# 2. نسخ الصور من public/images- إلى storage/app/public/images
echo "📂 نسخ الصور من public/images- إلى storage/app/public/images..."
if [ -d "public/images-" ]; then
    cp -r public/images-/* storage/app/public/images/
    echo "✅ تم نسخ الصور من public/images-"
else
    echo "❌ مجلد public/images- غير موجود"
fi

# 3. إنشاء صور العلامات التجارية (استخدام اللوغو كصورة مؤقتة)
echo "🏷️ إنشاء صور العلامات التجارية..."
if [ -f "storage/app/public/images/logo.jpg" ]; then
    cp storage/app/public/images/logo.jpg storage/app/public/brands/lenovo.jpg
    cp storage/app/public/images/logo.jpg storage/app/public/brands/dell.jpg
    cp storage/app/public/images/logo.jpg storage/app/public/brands/apple.jpg
    cp storage/app/public/images/logo.jpg storage/app/public/brands/hp.jpg
    cp storage/app/public/images/logo.jpg storage/app/public/brands/samsung.jpg
    echo "✅ تم إنشاء صور العلامات التجارية"
else
    echo "❌ ملف logo.jpg غير موجود"
fi

# 4. إنشاء صور الفئات
echo "📱 إنشاء صور الفئات..."
if [ -f "storage/app/public/images/logo.jpg" ]; then
    cp storage/app/public/images/logo.jpg storage/app/public/categories/laptops.jpg
    cp storage/app/public/images/logo.jpg storage/app/public/categories/gaming.jpg
    cp storage/app/public/images/logo.jpg storage/app/public/categories/computer-teile.jpg
    cp storage/app/public/images/logo.jpg storage/app/public/categories/gerate-reparieren.jpg
    echo "✅ تم إنشاء صور الفئات"
else
    echo "❌ ملف logo.jpg غير موجود"
fi

# 5. حذف الـ symbolic link القديم وإعادة إنشاؤه
echo "🔗 إعادة إنشاء الـ symbolic link..."
rm -rf public/storage

# محاولة إنشاء symbolic link
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
chmod -R 775 storage/app/public/
chmod -R 775 public/storage/

# 7. تحديث قاعدة البيانات
echo "🗃️ تحديث قاعدة البيانات..."
php artisan tinker << 'EOF'
// تحديث صور العلامات التجارية
App\Models\Brand::where('name', 'Lenovo')->update(['image' => 'brands/lenovo.jpg']);
App\Models\Brand::where('name', 'Dell')->update(['image' => 'brands/dell.jpg']);
App\Models\Brand::where('name', 'Apple')->update(['image' => 'brands/apple.jpg']);
App\Models\Brand::where('name', 'HP')->update(['image' => 'brands/hp.jpg']);
App\Models\Brand::where('name', 'Samsung')->update(['image' => 'brands/samsung.jpg']);

// تحديث صور الفئات
App\Models\Category::where('name', 'Laptops')->update(['image' => 'categories/laptops.jpg']);
App\Models\Category::where('name', 'Gaming')->update(['image' => 'categories/gaming.jpg']);
App\Models\Category::where('name', 'Computer Teile')->update(['image' => 'categories/computer-teile.jpg']);
App\Models\Category::where('name', 'Geräte reparieren')->update(['image' => 'categories/gerate-reparieren.jpg']);

echo "✅ تم تحديث قاعدة البيانات";
exit
EOF

# 8. تنظيف الـ cache
echo "🧹 تنظيف الـ cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. عرض النتائج
echo ""
echo "🎉 تم إصلاح مشكلة الصور بنجاح!"
echo "================================="
echo ""
echo "📊 ملخص العملية:"
echo "- تم نسخ الصور من public/images- إلى storage/app/public/images/"
echo "- تم إنشاء صور العلامات التجارية في storage/app/public/brands/"
echo "- تم إنشاء صور الفئات في storage/app/public/categories/"
echo "- تم تحديث قاعدة البيانات"
echo "- تم تنظيف الـ cache"
echo ""
echo "🧪 اختبار الصور:"
echo "- اذهب إلى: https://completitcompservice.de"
echo "- تأكد من ظهور صور 'Browse Popular Brands'"
echo "- اختبر الصور في صفحة الخدمات"
echo ""
echo "🔧 إذا لم تظهر الصور، اختبر هذه الروابط:"
echo "- https://completitcompservice.de/storage/brands/lenovo.jpg"
echo "- https://completitcompservice.de/storage/images/bg.jpg"
echo "- https://completitcompservice.de/storage/images/logo.jpg"
echo ""
echo "✅ العملية مكتملة!" 
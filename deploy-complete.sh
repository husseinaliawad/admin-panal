#!/bin/bash

echo "🚀 نشر كامل لمشروع CICS Laravel"
echo "================================="

# متغيرات الخادم
SERVER_USER="u102530462"
SERVER_HOST="46.202.156.244"
SERVER_PORT="65002"
SERVER_PATH="/home/u102530462/domains/completitcompservice.de/public_html"

echo "📦 تحضير الملفات للنشر..."

# إنشاء مجلد مؤقت للنشر
mkdir -p deploy-temp
cp -r . deploy-temp/
cd deploy-temp

# حذف الملفات غير المطلوبة
rm -rf node_modules .git vendor storage/logs/* storage/framework/cache/* storage/framework/sessions/* storage/framework/views/*
rm -f deploy-complete.sh sync-to-server.sh

# إنشاء ملف .env للإنتاج
cat > .env << 'EOF'
APP_NAME="CICS Computer & Services"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://completitcompservice.de

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u102530462_cics_db
DB_USERNAME=u102530462_cics_user
DB_PASSWORD=YOUR_DATABASE_PASSWORD

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=587
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="info@completitcompservice.de"
MAIL_FROM_NAME="${APP_NAME}"

FILAMENT_DOMAIN=completitcompservice.de

STRIPE_KEY=pk_test_your_stripe_key
STRIPE_SECRET=sk_test_your_stripe_secret
EOF

echo "🔄 رفع الملفات إلى الخادم..."

# رفع الملفات عبر rsync
rsync -avz --delete \
  --progress \
  -e "ssh -p $SERVER_PORT" \
  ./ $SERVER_USER@$SERVER_HOST:$SERVER_PATH/

cd ..
rm -rf deploy-temp

echo "⚙️ إعداد الخادم..."

# تشغيل أوامر الإعداد على الخادم
ssh -p $SERVER_PORT $SERVER_USER@$SERVER_HOST << 'ENDSSH'
cd /home/u102530462/domains/completitcompservice.de/public_html

echo "📁 إنشاء المجلدات المطلوبة..."
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions  
mkdir -p storage/framework/views
mkdir -p bootstrap/cache

echo "🔒 تعيين الصلاحيات..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R $USER:$USER storage
chown -R $USER:$USER bootstrap/cache

echo "📦 تثبيت dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "🔑 إنشاء Application Key..."
php artisan key:generate --force

echo "🔗 إنشاء Storage Link..."
# حذف الـ link القديم إذا كان موجود
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

echo "🗃️ تحديث قاعدة البيانات..."
php artisan migrate --force

# تحديث صور العلامات التجارية في قاعدة البيانات
php artisan tinker << 'EOF'
App\Models\Brand::where('name', 'Lenovo')->update(['image' => 'brands/lenovo.jpg']);
App\Models\Brand::where('name', 'Dell')->update(['image' => 'brands/dell.jpg']);
App\Models\Brand::where('name', 'Apple')->update(['image' => 'brands/apple.jpg']);
App\Models\Brand::where('name', 'HP')->update(['image' => 'brands/hp.jpg']);
App\Models\Brand::where('name', 'Samsung')->update(['image' => 'brands/samsung.jpg']);

App\Models\Category::where('name', 'Laptops')->update(['image' => 'categories/laptops.jpg']);
App\Models\Category::where('name', 'Gaming')->update(['image' => 'categories/gaming.jpg']);
App\Models\Category::where('name', 'Computer Teile')->update(['image' => 'categories/computer-teile.jpg']);
App\Models\Category::where('name', 'Geräte reparieren')->update(['image' => 'categories/gerate-reparieren.jpg']);
echo "✅ تم تحديث قاعدة البيانات";
exit
EOF

# 3. إنشاء صور العلامات التجارية (صور مختلفة لكل علامة)
echo "🏷️ إنشاء صور العلامات التجارية المختلفة..."
if [ -f "storage/app/public/images/card1.jpeg" ]; then
    cp storage/app/public/images/card1.jpeg storage/app/public/brands/lenovo.jpg
    cp storage/app/public/images/card2.jpeg storage/app/public/brands/dell.jpg
    cp storage/app/public/images/card3.jpeg storage/app/public/brands/apple.jpg
    cp storage/app/public/images/card4.jpeg storage/app/public/brands/hp.jpg
    cp storage/app/public/images/card5.jpeg storage/app/public/brands/samsung.jpg
    echo "✅ تم إنشاء صور العلامات التجارية المختلفة"
else
    echo "❌ ملفات card*.jpeg غير موجودة"
fi

# 4. إنشاء صور الفئات (صور مختلفة لكل فئة)
echo "📱 إنشاء صور الفئات المختلفة..."
if [ -f "storage/app/public/images/card6.jpeg" ]; then
    cp storage/app/public/images/card6.jpeg storage/app/public/categories/laptops.jpg
    cp storage/app/public/images/card7.jpeg storage/app/public/categories/gaming.jpg
    cp storage/app/public/images/card8.jpeg storage/app/public/categories/computer-teile.jpg
    cp storage/app/public/images/card9.jpeg storage/app/public/categories/gerate-reparieren.jpg
    echo "✅ تم إنشاء صور الفئات المختلفة"
else
    echo "❌ ملفات card*.jpeg للفئات غير موجودة"
fi

echo "🧹 تنظيف وتحسين الـ Cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔧 التحقق النهائي..."
ls -la storage/app/public/images/ | head -5
ls -la storage/app/public/brands/
ls -la public/storage/brands/

echo ""
echo "🎉 تم النشر بنجاح!"
echo "==================="
echo ""
echo "🧪 اختبر الموقع الآن:"
echo "- الموقع الرئيسي: https://completitcompservice.de"
echo "- لوحة الإدارة: https://completitcompservice.de/admin"
echo ""
echo "🖼️ اختبر الصور:"
echo "- https://completitcompservice.de/storage/brands/lenovo.jpg"
echo "- https://completitcompservice.de/storage/images/bg.jpg"
echo "- https://completitcompservice.de/storage/images/logo.jpg"
echo ""
echo "✅ العملية مكتملة!"

ENDSSH

echo ""
echo "🎯 تم الانتهاء من النشر الكامل!"
echo "================================"
echo ""
echo "📋 ما تم تنفيذه:"
echo "1. ✅ رفع جميع ملفات المشروع"
echo "2. ✅ إعداد بيئة الإنتاج" 
echo "3. ✅ تثبيت Dependencies"
echo "4. ✅ إنشاء Storage Links"
echo "5. ✅ تحديث قاعدة البيانات"
echo "6. ✅ إصلاح مسارات الصور"
echo "7. ✅ تحسين الـ Cache"
echo ""
echo "🌐 اختبر موقعك الآن: https://completitcompservice.de" 
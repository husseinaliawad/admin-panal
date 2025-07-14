# دليل تثبيت وإعداد MySQL

## 🎯 تم تحديث إعدادات قاعدة البيانات بنجاح!

تم تحويل المشروع من SQLite إلى MySQL. الآن تحتاج إلى تثبيت MySQL وإنشاء قاعدة البيانات.

## 📋 إعدادات قاعدة البيانات الحالية:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admin_panel
DB_USERNAME=root
DB_PASSWORD=(فارغة)
```

## 🔧 خيارات تثبيت MySQL:

### الخيار 1: XAMPP (الأسهل - مُوصى به)
1. حمل XAMPP من: https://www.apachefriends.org/
2. ثبت XAMPP
3. شغل XAMPP Control Panel
4. ابدأ خدمات Apache و MySQL
5. افتح http://localhost/phpmyadmin
6. انشئ قاعدة بيانات جديدة باسم `admin_panel`

### الخيار 2: MySQL Community Server
1. حمل من: https://dev.mysql.com/downloads/mysql/
2. ثبت MySQL Server
3. اضبط كلمة مرور root (أو اتركها فارغة)
4. استخدم MySQL Workbench أو command line

### الخيار 3: WAMP/MAMP
1. حمل WAMP (Windows) أو MAMP (Mac)
2. ثبت وشغل الخدمات
3. استخدم phpMyAdmin

## 📝 خطوات الإعداد بعد تثبيت MySQL:

### 1. إنشاء قاعدة البيانات:
```sql
CREATE DATABASE admin_panel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

أو استخدم الملف المرفق: `setup_mysql.sql`

### 2. تشغيل الـ Migrations:
```bash
php artisan config:clear
php artisan migrate:fresh --seed
```

### 3. إنشاء مستخدم الإدارة:
```bash
php artisan tinker --execute="
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@admin.com',
    'password' => Hash::make('password'),
    'email_verified_at' => now()
]);
"
```

### 4. إنشاء بيانات تجريبية:
```bash
php artisan tinker --execute="
App\Models\Category::create(['name' => 'Electronics', 'slug' => 'electronics', 'image' => 'categories/electronics.jpg', 'is_active' => 1]);
App\Models\Category::create(['name' => 'Fashion', 'slug' => 'fashion', 'image' => 'categories/fashion.jpg', 'is_active' => 1]);
App\Models\Brand::create(['name' => 'Apple', 'slug' => 'apple', 'image' => 'brands/apple.jpg', 'is_active' => 1]);
App\Models\Brand::create(['name' => 'Samsung', 'slug' => 'samsung', 'image' => 'brands/samsung.jpg', 'is_active' => 1]);
"
```

## 🚀 تشغيل المشروع:
```bash
php artisan serve
```

## 🔍 التحقق من الاتصال:
```bash
php artisan tinker --execute="DB::connection()->getPdo(); echo 'MySQL connection successful!';"
```

## ⚠️ حل المشاكل الشائعة:

### خطأ: "Connection refused"
- تأكد من تشغيل خدمة MySQL
- تحقق من المنفذ 3306

### خطأ: "Access denied"
- تحقق من اسم المستخدم وكلمة المرور
- تأكد من صلاحيات المستخدم

### خطأ: "Database doesn't exist"
- أنشئ قاعدة البيانات `admin_panel` أولاً

## 📞 الدعم:
إذا واجهت أي مشاكل، تأكد من:
1. تشغيل خدمة MySQL
2. صحة بيانات الاتصال في ملف .env
3. وجود قاعدة البيانات admin_panel 
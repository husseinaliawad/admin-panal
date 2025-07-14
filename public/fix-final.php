<?php
/**
 * 🔧 أداة الإصلاح النهائية
 * هذه الأداة تحل مشكلة /public/ في المسارات
 */

echo "<h1>🔧 أداة الإصلاح النهائية</h1>";
echo "<style>
body{font-family:Arial;margin:40px;} 
.success{color:green;} 
.error{color:red;} 
.info{color:blue;}
.warning{color:orange;}
.section{background:#f5f5f5;padding:20px;border-radius:8px;margin:20px 0;}
.code-block{background:#f8f8f8;padding:15px;border-radius:5px;margin:10px 0;overflow-x:auto;}
.step{margin:15px 0;padding:10px;background:#e8f4f8;border-radius:5px;}
</style>";

echo "<div class='section'>";
echo "<h2>📋 تشخيص المشكلة</h2>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Current Directory: " . __DIR__ . "</p>";
echo "<p>مسار الموقع: " . $_SERVER['HTTP_HOST'] . "</p>";

// تحقق من وجود .htaccess في المجلد الجذر
$rootHtaccess = $_SERVER['DOCUMENT_ROOT'] . '/.htaccess';
if (file_exists($rootHtaccess)) {
    echo "<p class='success'>✅ ملف .htaccess موجود في المجلد الجذر</p>";
} else {
    echo "<p class='error'>❌ ملف .htaccess غير موجود في المجلد الجذر</p>";
}

// تحقق من وجود .htaccess في مجلد public
$publicHtaccess = __DIR__ . '/.htaccess';
if (file_exists($publicHtaccess)) {
    echo "<p class='success'>✅ ملف .htaccess موجود في مجلد public</p>";
} else {
    echo "<p class='error'>❌ ملف .htaccess غير موجود في مجلد public</p>";
}
echo "</div>";

// الحل 1: إنشاء .htaccess في المجلد الجذر
echo "<div class='section'>";
echo "<h2>🔧 الحل 1: إنشاء .htaccess في المجلد الجذر</h2>";

$rootHtaccessContent = '<IfModule mod_rewrite.c>
    RewriteEngine On

    # إعادة توجيه من أي مسار يحتوي على /public/ إلى نفس المسار بدون /public/
    RewriteCond %{THE_REQUEST} \s/+public/([^\s?]*) [NC]
    RewriteRule ^ /%1 [R=301,L]

    # توجيه جميع الطلبات غير الموجودة إلى مجلد public
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>';

if (isset($_POST['create_root_htaccess'])) {
    if (file_put_contents($rootHtaccess, $rootHtaccessContent)) {
        echo "<p class='success'>✅ تم إنشاء .htaccess في المجلد الجذر بنجاح!</p>";
    } else {
        echo "<p class='error'>❌ فشل في إنشاء .htaccess في المجلد الجذر</p>";
    }
}

echo "<p class='info'>هذا الحل يحل مشكلة المسارات بدون تغيير بنية الملفات</p>";
echo '<form method="post" style="margin:10px 0;">';
echo '<button type="submit" name="create_root_htaccess" style="background:#28a745;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;">إنشاء .htaccess في المجلد الجذر</button>';
echo '</form>';

echo "<p class='warning'>⚠️ ملاحظة: هذا الحل يتطلب صلاحيات كتابة في المجلد الجذر</p>";
echo "</div>";

// الحل 2: نسخ محتوى .htaccess يدوياً
echo "<div class='section'>";
echo "<h2>📋 الحل 2: نسخ محتوى .htaccess يدوياً</h2>";
echo "<p class='info'>إذا لم يعمل الحل الأول، انسخ هذا المحتوى في ملف .htaccess جديد في مجلد public_html:</p>";
echo "<div class='code-block'>";
echo "<pre>" . htmlspecialchars($rootHtaccessContent) . "</pre>";
echo "</div>";
echo "</div>";

// اختبار الحل
echo "<div class='section'>";
echo "<h2>🧪 اختبار الحل</h2>";
echo "<p>بعد تطبيق الحل، اختبر هذه الروابط:</p>";
$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$testLinks = [
    'public/categories/' => 'categories/',
    'public/products/' => 'products/',
    'public/admin/' => 'admin/',
];

foreach ($testLinks as $wrong => $correct) {
    echo "<div class='step'>";
    echo "<strong>اختبار:</strong> <a href='$baseUrl/$wrong' target='_blank'>$baseUrl/$wrong</a>";
    echo "<br><strong>يجب أن يعيد التوجيه إلى:</strong> $baseUrl/$correct";
    echo "</div>";
}
echo "</div>";

// معلومات إضافية
echo "<div class='section'>";
echo "<h2>ℹ️ معلومات إضافية</h2>";
echo "<p class='info'>إذا استمرت المشكلة، قد تحتاج إلى:</p>";
echo "<ul>";
echo "<li>التأكد من أن mod_rewrite مفعل في الخادم</li>";
echo "<li>التأكد من صلاحيات الملفات (644 لملف .htaccess)</li>";
echo "<li>مراجعة error log للخادم</li>";
echo "<li>الاتصال بمزود الخدمة للمساعدة</li>";
echo "</ul>";
echo "</div>";

echo "<div class='section'>";
echo "<h2>📞 الحل الأمثل</h2>";
echo "<p class='warning'>الحل الأمثل هو إعادة تنظيم الملفات بحيث يكون محتوى مجلد public في مجلد public_html مباشرة</p>";
echo "<p>لكن هذا يتطلب خبرة تقنية أكبر</p>";
echo "</div>";

?> 
<?php
/**
 * أداة سريعة لجعل المستخدم مشرف
 */

echo "<h2>👑 جعل المستخدم مشرف</h2>";
echo "<style>
body{font-family:Arial;margin:40px;direction:rtl;} 
.success{color:green;} 
.error{color:red;} 
.info{color:blue;}
</style>";

// إعدادات قاعدة البيانات
$host = 'localhost';
$dbname = 'u102530462_cics_db';
$username = 'u102530462_cics_user';
$password = 'Lina2026.';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // تحقق من وجود عمود is_admin
    $checkColumn = $pdo->query("SHOW COLUMNS FROM users LIKE 'is_admin'");
    $columnExists = $checkColumn->rowCount() > 0;
    
    if (!$columnExists) {
        echo "<div class='info'>⚠️ إضافة عمود is_admin لجدول المستخدمين...</div>";
        $pdo->exec("ALTER TABLE users ADD COLUMN is_admin BOOLEAN DEFAULT FALSE");
        echo "<div class='success'>✅ تم إضافة عمود is_admin بنجاح!</div>";
    }
    
    // جعل المستخدم queen2026@gmail.com مشرف
    $stmt = $pdo->prepare("UPDATE users SET is_admin = 1 WHERE email = ?");
    $result = $stmt->execute(['queen2026@gmail.com']);
    
    if ($stmt->rowCount() > 0) {
        echo "<div class='success'>✅ تم جعل المستخدم queen2026@gmail.com مشرف بنجاح!</div>";
        echo "<div class='info'>🔗 يمكنك الآن الدخول للأدمن بانل: <a href='/admin' target='_blank'>https://completitcompservice.de/admin</a></div>";
    } else {
        echo "<div class='error'>❌ لم يتم العثور على المستخدم queen2026@gmail.com</div>";
        echo "<div class='info'>💡 تأكد من تسجيل الدخول بهذا الإيميل أولاً في الموقع الرئيسي</div>";
    }
    
    // عرض جميع المستخدمين المشرفين
    $stmt = $pdo->query("SELECT name, email, created_at FROM users WHERE is_admin = 1");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>👥 المشرفين الحاليين:</h3>";
    if (!empty($admins)) {
        echo "<ul>";
        foreach ($admins as $admin) {
            echo "<li><strong>{$admin['name']}</strong> - {$admin['email']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>لا يوجد مشرفين حالياً</p>";
    }
    
} catch(PDOException $e) {
    echo "<div class='error'>❌ خطأ في قاعدة البيانات: " . $e->getMessage() . "</div>";
}
?>

<hr>
<div class="info">
    <h3>🔧 الخطوات التالية:</h3>
    <ol>
        <li>تأكد من تسجيل الدخول بالإيميل queen2026@gmail.com في الموقع الرئيسي</li>
        <li>بعد تشغيل هذا الملف، يمكنك الدخول للأدمن بانل</li>
        <li>استخدم <a href="manage-admins.php">manage-admins.php</a> لإدارة المشرفين مستقبلاً</li>
        <li>احذف هذا الملف بعد الانتهاء!</li>
    </ol>
</div> 
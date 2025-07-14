<?php
/**
 * Migration محلي لإضافة حقل is_admin
 */

echo "<h2>🔄 تشغيل Migration محلي - إضافة حقل is_admin</h2>";
echo "<style>
body{font-family:Arial;margin:40px;direction:rtl;} 
.success{color:green;} 
.error{color:red;} 
.info{color:blue;}
</style>";

// إعدادات قاعدة البيانات المحلية
$host = '127.0.0.1';
$dbname = 'admin_panel';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div class='success'>✅ تم الاتصال بقاعدة البيانات المحلية بنجاح!</div>";
    
    // تحقق من وجود جدول users
    $checkUsers = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($checkUsers->rowCount() == 0) {
        echo "<div class='error'>❌ جدول users غير موجود! يرجى تشغيل migrations الأساسية أولاً.</div>";
        exit;
    }
    
    // تحقق من وجود عمود is_admin
    $checkColumn = $pdo->query("SHOW COLUMNS FROM users LIKE 'is_admin'");
    $columnExists = $checkColumn->rowCount() > 0;
    
    if ($columnExists) {
        echo "<div class='info'>⚠️ عمود is_admin موجود بالفعل!</div>";
    } else {
        echo "<div class='info'>🔄 إضافة عمود is_admin إلى جدول users...</div>";
        
        // إضافة عمود is_admin
        $sql = "ALTER TABLE users ADD COLUMN is_admin BOOLEAN NOT NULL DEFAULT FALSE";
        $pdo->exec($sql);
        
        echo "<div class='success'>✅ تم إضافة عمود is_admin بنجاح!</div>";
    }
    
    // إضافة مستخدم مشرف تجريبي
    $testEmail = 'admin@test.com';
    $checkAdmin = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $checkAdmin->execute([$testEmail]);
    
    if ($checkAdmin->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_admin, created_at, updated_at) VALUES (?, ?, ?, 1, NOW(), NOW())");
        $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
        $stmt->execute(['Admin User', $testEmail, $hashedPassword]);
        echo "<div class='success'>✅ تم إنشاء مستخدم مشرف تجريبي: admin@test.com / password</div>";
    } else {
        // تحديث المستخدم الموجود لجعله مشرف
        $stmt = $pdo->prepare("UPDATE users SET is_admin = 1 WHERE email = ?");
        $stmt->execute([$testEmail]);
        echo "<div class='success'>✅ تم تحديث المستخدم admin@test.com ليصبح مشرف</div>";
    }
    
    // التحقق من النتيجة النهائية
    $checkFinal = $pdo->query("DESCRIBE users");
    $columns = $checkFinal->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>📋 أعمدة جدول users الحالية:</h3>";
    echo "<table border='1' style='border-collapse:collapse;width:100%;'>";
    echo "<tr><th>اسم العمود</th><th>النوع</th><th>NULL</th><th>القيمة الافتراضية</th></tr>";
    
    foreach ($columns as $column) {
        $highlight = $column['Field'] === 'is_admin' ? 'background-color:#e8f5e8;' : '';
        echo "<tr style='$highlight'>";
        echo "<td>{$column['Field']}</td>";
        echo "<td>{$column['Type']}</td>";
        echo "<td>{$column['Null']}</td>";
        echo "<td>{$column['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // عرض المشرفين
    $admins = $pdo->query("SELECT name, email FROM users WHERE is_admin = 1");
    echo "<h3>👑 المشرفين الحاليين:</h3>";
    echo "<ul>";
    foreach ($admins as $admin) {
        echo "<li><strong>{$admin['name']}</strong> - {$admin['email']}</li>";
    }
    echo "</ul>";
    
} catch(PDOException $e) {
    echo "<div class='error'>❌ خطأ في قاعدة البيانات: " . $e->getMessage() . "</div>";
    echo "<div class='info'>💡 تأكد من تشغيل MySQL وإنشاء قاعدة البيانات 'admin_panel'</div>";
}
?>

<hr>
<div class="info">
    <h3>🎯 للاستخدام:</h3>
    <ol>
        <li>تأكد من تشغيل MySQL محلياً</li>
        <li>تأكد من وجود قاعدة بيانات 'admin_panel'</li>
        <li>افتح هذا الملف في المتصفح</li>
        <li>استخدم admin@test.com / password للدخول</li>
    </ol>
</div> 
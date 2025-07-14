<?php
/**
 * منشئ المستخدم الإداري البسيط
 * يجرب طرق مختلفة للاتصال بقاعدة البيانات
 */
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إنشاء مستخدم إداري</title>
    <style>
        body { font-family: Arial; margin: 40px; background: #f8f9fa; direction: rtl; }
        .success { color: #28a745; background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { color: #dc3545; background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .info { color: #17a2b8; background: #d1ecf1; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .warning { color: #856404; background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .form-group { margin: 15px 0; }
        input[type="text"], input[type="password"] { padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #007cba; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #005a8b; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: right; }
        th { background: #f8f9fa; }
    </style>
</head>
<body>

<h2>🔐 منشئ المستخدم الإداري</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'] ?? 'localhost';
    $dbname = $_POST['dbname'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($dbname) || empty($username)) {
        echo "<div class='error'>❌ يرجى إدخال جميع البيانات المطلوبة</div>";
    } else {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo "<div class='success'>✅ تم الاتصال بقاعدة البيانات بنجاح!</div>";
            
            // إنشاء أو تحديث المستخدم الإداري
            $adminEmail = 'admin@admin.com';
            $adminPassword = 'password';
            $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
            
            // التحقق من وجود المستخدم
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$adminEmail]);
            $existingUser = $stmt->fetch();
            
            if ($existingUser) {
                // تحديث المستخدم الموجود
                $stmt = $pdo->prepare("UPDATE users SET password = ?, email_verified_at = NOW(), updated_at = NOW() WHERE email = ?");
                $stmt->execute([$hashedPassword, $adminEmail]);
                echo "<div class='success'>✅ تم تحديث المستخدم الإداري الموجود!</div>";
            } else {
                // إنشاء مستخدم جديد
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, email_verified_at, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW(), NOW())");
                $stmt->execute(['Admin', $adminEmail, $hashedPassword]);
                echo "<div class='success'>✅ تم إنشاء مستخدم إداري جديد!</div>";
            }
            
            // عرض بيانات الدخول
            echo "<div style='padding:20px;background:#f8f9fa;border:2px solid #007cba;border-radius:8px;margin:20px 0;'>";
            echo "<h3>🎯 بيانات الدخول للإدمن:</h3>";
            echo "<p><strong>📧 الإيميل:</strong> <code>$adminEmail</code></p>";
            echo "<p><strong>🔑 كلمة المرور:</strong> <code>$adminPassword</code></p>";
            echo "<p><strong>🔗 رابط الإدمن:</strong> <a href='/admin' target='_blank'>https://completitcompservice.de/admin</a></p>";
            echo "</div>";
            
            // عرض جميع المستخدمين
            $stmt = $pdo->prepare("SELECT id, name, email, created_at FROM users ORDER BY id");
            $stmt->execute();
            $users = $stmt->fetchAll();
            
            if ($users) {
                echo "<h3>👥 جميع المستخدمين:</h3>";
                echo "<table>";
                echo "<tr><th>ID</th><th>الاسم</th><th>الإيميل</th><th>تاريخ الإنشاء</th></tr>";
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>{$user['id']}</td>";
                    echo "<td>{$user['name']}</td>";
                    echo "<td>{$user['email']}</td>";
                    echo "<td>{$user['created_at']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            
        } catch (PDOException $e) {
            echo "<div class='error'>❌ خطأ في الاتصال: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
    
    echo "<hr>";
}
?>

<div class="info">
    <h3>📋 البيانات المتوقعة لاستضافة Hostinger:</h3>
    <ul>
        <li><strong>الخادم:</strong> localhost</li>
        <li><strong>قاعدة البيانات:</strong> u102530462_cics_db</li>
        <li><strong>المستخدم:</strong> u102530462_cics_user</li>
        <li><strong>كلمة المرور:</strong> تحتاج للحصول عليها من cPanel</li>
    </ul>
</div>

<form method="POST">
    <div class="form-group">
        <label>🖥️ الخادم:</label><br>
        <input type="text" name="host" value="<?= htmlspecialchars($_POST['host'] ?? 'localhost') ?>" required>
    </div>
    
    <div class="form-group">
        <label>🗄️ اسم قاعدة البيانات:</label><br>
        <input type="text" name="dbname" value="<?= htmlspecialchars($_POST['dbname'] ?? 'u102530462_cics_db') ?>" required>
    </div>
    
    <div class="form-group">
        <label>👤 اسم المستخدم:</label><br>
        <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? 'u102530462_cics_user') ?>" required>
    </div>
    
    <div class="form-group">
        <label>🔑 كلمة المرور:</label><br>
        <input type="password" name="password" value="<?= htmlspecialchars($_POST['password'] ?? '') ?>" required>
    </div>
    
    <button type="submit">🔐 إنشاء/تحديث المستخدم الإداري</button>
</form>

<div class="warning">
    <h4>🔧 كيفية الحصول على بيانات قاعدة البيانات:</h4>
    <ol>
        <li>ادخل إلى <strong>cPanel</strong></li>
        <li>اذهب إلى <strong>MySQL Databases</strong></li>
        <li>ابحث عن قاعدة البيانات واسم المستخدم</li>
        <li>إذا نسيت كلمة المرور، يمكنك تغييرها من هناك</li>
    </ol>
</div>

</body>
</html> 
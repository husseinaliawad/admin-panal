<?php
/**
 * إعداد قاعدة بيانات SQLite محلية وتشغيل migration
 */

echo "<h2>🔄 إعداد قاعدة بيانات محلية وتشغيل Migration</h2>";
echo "<style>
body{font-family:Arial;margin:40px;direction:rtl;} 
.success{color:green;} 
.error{color:red;} 
.info{color:blue;}
</style>";

// 1. إنشاء قاعدة بيانات SQLite
$dbPath = __DIR__ . '/database/database.sqlite';
$dbDir = dirname($dbPath);

echo "<div class='info'>🔄 إنشاء قاعدة بيانات SQLite...</div>";

// إنشاء مجلد database إذا لم يكن موجود
if (!is_dir($dbDir)) {
    mkdir($dbDir, 0755, true);
}

// إنشاء ملف قاعدة البيانات
if (!file_exists($dbPath)) {
    touch($dbPath);
    echo "<div class='success'>✅ تم إنشاء قاعدة بيانات SQLite: $dbPath</div>";
} else {
    echo "<div class='info'>⚠️ قاعدة بيانات SQLite موجودة بالفعل</div>";
}

// 2. الاتصال بقاعدة البيانات
try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div class='success'>✅ تم الاتصال بقاعدة البيانات بنجاح!</div>";
    
    // 3. إنشاء جدول users إذا لم يكن موجود
    $createUsersTable = "
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            email_verified_at DATETIME,
            password TEXT NOT NULL,
            is_admin BOOLEAN DEFAULT 0,
            remember_token TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ";
    
    $pdo->exec($createUsersTable);
    echo "<div class='success'>✅ تم إنشاء جدول users مع حقل is_admin!</div>";
    
    // 4. إنشاء مستخدم مشرف تجريبي
    $testEmail = 'admin@test.com';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$testEmail]);
    
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, 1)");
        $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
        $stmt->execute(['Admin User', $testEmail, $hashedPassword]);
        echo "<div class='success'>✅ تم إنشاء مستخدم مشرف: admin@test.com / password</div>";
    } else {
        $stmt = $pdo->prepare("UPDATE users SET is_admin = 1 WHERE email = ?");
        $stmt->execute([$testEmail]);
        echo "<div class='success'>✅ تم تحديث المستخدم ليصبح مشرف</div>";
    }
    
    // 5. عرض المشرفين
    echo "<h3>👑 المشرفين الحاليين:</h3>";
    $admins = $pdo->query("SELECT name, email FROM users WHERE is_admin = 1")->fetchAll(PDO::FETCH_ASSOC);
    echo "<ul>";
    foreach ($admins as $admin) {
        echo "<li><strong>{$admin['name']}</strong> - {$admin['email']}</li>";
    }
    echo "</ul>";
    
} catch(PDOException $e) {
    echo "<div class='error'>❌ خطأ في قاعدة البيانات: " . $e->getMessage() . "</div>";
}

?>

<hr>
<div class="info">
    <h3>🎯 تم إنشاء قاعدة بيانات SQLite مع:</h3>
    <ul>
        <li>✅ جدول users مع حقل is_admin</li>
        <li>✅ مستخدم مشرف: admin@test.com / password</li>
        <li>✅ قاعدة بيانات في: database/database.sqlite</li>
    </ul>
</div> 
<?php
/**
 * إنشاء قاعدة بيانات MySQL admin_panel وتشغيل migration
 */

echo "<h2>🔄 إنشاء قاعدة بيانات MySQL admin_panel</h2>";
echo "<style>
body{font-family:Arial;margin:40px;direction:rtl;} 
.success{color:green;} 
.error{color:red;} 
.info{color:blue;}
</style>";

// إعدادات MySQL للـ XAMPP
$host = '127.0.0.1';
$username = 'root';
$password = ''; // فارغة في XAMPP الافتراضي
$dbname = 'admin_panel';

try {
    // 1. الاتصال بـ MySQL بدون تحديد قاعدة بيانات
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div class='success'>✅ تم الاتصال بـ MySQL بنجاح!</div>";
    
    // 2. إنشاء قاعدة البيانات admin_panel
    $createDb = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdo->exec($createDb);
    echo "<div class='success'>✅ تم إنشاء قاعدة البيانات: $dbname</div>";
    
    // 3. استخدام قاعدة البيانات
    $pdo->exec("USE `$dbname`");
    
    // 4. إنشاء جدول users
    $createUsersTable = "
        CREATE TABLE IF NOT EXISTS `users` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `email_verified_at` timestamp NULL DEFAULT NULL,
            `password` varchar(255) NOT NULL,
            `is_admin` tinyint(1) NOT NULL DEFAULT '0',
            `remember_token` varchar(100) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `users_email_unique` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    $pdo->exec($createUsersTable);
    echo "<div class='success'>✅ تم إنشاء جدول users مع حقل is_admin!</div>";
    
    // 5. إنشاء جدول migrations
    $createMigrationsTable = "
        CREATE TABLE IF NOT EXISTS `migrations` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `migration` varchar(255) NOT NULL,
            `batch` int(11) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";
    
    $pdo->exec($createMigrationsTable);
    echo "<div class='success'>✅ تم إنشاء جدول migrations!</div>";
    
    // 6. إضافة سجل migration
    $migrationName = '2025_07_14_051005_add_is_admin_to_users_table';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM migrations WHERE migration = ?");
    $stmt->execute([$migrationName]);
    
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare("INSERT INTO migrations (migration, batch) VALUES (?, 1)");
        $stmt->execute([$migrationName]);
        echo "<div class='success'>✅ تم تسجيل Migration!</div>";
    }
    
    // 7. إنشاء مستخدم مشرف تجريبي
    $testEmail = 'admin@test.com';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$testEmail]);
    
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_admin, created_at, updated_at) VALUES (?, ?, ?, 1, NOW(), NOW())");
        $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
        $stmt->execute(['Admin User', $testEmail, $hashedPassword]);
        echo "<div class='success'>✅ تم إنشاء مستخدم مشرف: admin@test.com / password</div>";
    } else {
        $stmt = $pdo->prepare("UPDATE users SET is_admin = 1 WHERE email = ?");
        $stmt->execute([$testEmail]);
        echo "<div class='success'>✅ تم تحديث المستخدم ليصبح مشرف</div>";
    }
    
    // 8. عرض الجداول
    echo "<h3>📋 جداول قاعدة البيانات:</h3>";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul>";
    
    // 9. عرض المشرفين
    echo "<h3>👑 المشرفين الحاليين:</h3>";
    $admins = $pdo->query("SELECT name, email FROM users WHERE is_admin = 1")->fetchAll(PDO::FETCH_ASSOC);
    echo "<ul>";
    foreach ($admins as $admin) {
        echo "<li><strong>{$admin['name']}</strong> - {$admin['email']}</li>";
    }
    echo "</ul>";
    
    // 10. عرض أعمدة جدول users
    echo "<h3>📋 أعمدة جدول users:</h3>";
    $columns = $pdo->query("DESCRIBE users")->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border='1' style='border-collapse:collapse;width:100%;'>";
    echo "<tr><th>العمود</th><th>النوع</th><th>NULL</th><th>افتراضي</th></tr>";
    
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
    
} catch(PDOException $e) {
    echo "<div class='error'>❌ خطأ في قاعدة البيانات: " . $e->getMessage() . "</div>";
    echo "<div class='info'>💡 تأكد من تشغيل MySQL في XAMPP Control Panel</div>";
}
?>

<hr>
<div class="info">
    <h3>🎯 تم إنشاء قاعدة بيانات MySQL بنجاح!</h3>
    <ul>
        <li>✅ قاعدة البيانات: admin_panel</li>
        <li>✅ جدول users مع حقل is_admin</li>
        <li>✅ مستخدم مشرف: admin@test.com / password</li>
        <li>✅ جدول migrations</li>
    </ul>
    
    <h3>🔧 الخطوات التالية:</h3>
    <ol>
        <li>قم بتحديث ملف .env للاستخدام مع MySQL</li>
        <li>أو استخدم: <code>php artisan migrate</code></li>
        <li>ثم: <code>php artisan serve</code></li>
    </ol>
</div> 
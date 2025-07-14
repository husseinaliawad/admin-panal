<?php
// إنشاء قاعدة بيانات MySQL admin_panel سريعاً
try {
    $pdo = new PDO("mysql:host=127.0.0.1", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // إنشاء قاعدة البيانات
    $pdo->exec("CREATE DATABASE IF NOT EXISTS admin_panel");
    echo "✅ تم إنشاء قاعدة البيانات admin_panel\n";
    
    // استخدام قاعدة البيانات
    $pdo->exec("USE admin_panel");
    
    // إنشاء جدول users
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        is_admin BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
    echo "✅ تم إنشاء جدول users مع حقل is_admin\n";
    
    // إنشاء مستخدم مشرف
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (name, email, password, is_admin) VALUES (?, ?, ?, 1)");
    $stmt->execute(['Admin User', 'admin@test.com', password_hash('password', PASSWORD_DEFAULT)]);
    echo "✅ تم إنشاء مستخدم مشرف: admin@test.com / password\n";
    
    echo "\n🎯 إعدادات .env:\n";
    echo "DB_CONNECTION=mysql\n";
    echo "DB_HOST=127.0.0.1\n";
    echo "DB_PORT=3306\n";
    echo "DB_DATABASE=admin_panel\n";
    echo "DB_USERNAME=root\n";
    echo "DB_PASSWORD=\n";
    
} catch(PDOException $e) {
    echo "❌ خطأ: " . $e->getMessage() . "\n";
    echo "💡 تأكد من تشغيل MySQL في XAMPP\n";
}
?> 
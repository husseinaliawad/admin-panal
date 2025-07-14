<?php
// التحقق من حالة قاعدة البيانات
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=admin_panel", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ متصل بقاعدة البيانات admin_panel\n\n";
    
    // التحقق من الجداول
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "📋 الجداول الموجودة:\n";
    foreach ($tables as $table) {
        echo "  - $table\n";
    }
    
    // التحقق من أعمدة جدول users
    echo "\n📋 أعمدة جدول users:\n";
    $columns = $pdo->query("DESCRIBE users")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        $admin_highlight = $col['Field'] === 'is_admin' ? ' 👑' : '';
        echo "  - {$col['Field']} ({$col['Type']})$admin_highlight\n";
    }
    
    // عرض المستخدمين
    echo "\n👤 المستخدمين:\n";
    $users = $pdo->query("SELECT id, name, email, is_admin FROM users")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        $admin_badge = $user['is_admin'] ? ' 👑 مشرف' : '';
        echo "  - {$user['name']} ({$user['email']})$admin_badge\n";
    }
    
    if (empty($users)) {
        echo "  لا يوجد مستخدمين\n";
    }
    
    echo "\n🎯 حالة النظام:\n";
    echo "✅ قاعدة البيانات: admin_panel\n";
    echo "✅ جدول users مع حقل is_admin\n";
    echo "✅ جاهز للاستخدام مع Laravel\n";
    
} catch(PDOException $e) {
    echo "❌ خطأ: " . $e->getMessage() . "\n";
}
?> 
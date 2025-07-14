<?php
// حل سريع لإنشاء مستخدم إداري
echo "<h2>🔧 إنشاء مستخدم إداري - حل سريع</h2>";

// الاتصال بقاعدة البيانات - بيانات محدثة
$host = 'localhost';
$dbname = 'u102530462_cics_db'; // اسم قاعدة البيانات الصحيح
$username = 'u102530462_cics_user'; // اسم المستخدم الصحيح

// جرب كلمات مرور محتملة
$possiblePasswords = [
    'Hussein@123',
    'password123',
    'YOUR_DATABASE_PASSWORD', 
    'cics_password',
    'Password@123'
];

$connected = false;
$pdo = null;

foreach ($possiblePasswords as $password) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<div style='color:green;padding:10px;background:#d4edda;border-radius:5px;margin:10px 0;'>✅ تم الاتصال بقاعدة البيانات بنجاح!</div>";
        $connected = true;
        break;
    } catch(PDOException $e) {
        continue; // جرب كلمة المرور التالية
    }
}

if (!$connected) {
    echo "<div style='color:#dc3545;padding:15px;background:#f8d7da;border-radius:5px;margin:20px 0;'>";
    echo "<h3>❌ فشل الاتصال بقاعدة البيانات</h3>";
    echo "<p><strong>المشكلة:</strong> لا يمكن الاتصال بقاعدة البيانات باستخدام البيانات المتاحة.</p>";
    echo "<p><strong>الحل:</strong> تحديث كلمة مرور قاعدة البيانات في السكريبت أدناه:</p>";
    echo "</div>";
    
    echo "<div style='background:#f8f9fa;padding:20px;border-radius:5px;margin:20px 0;'>";
    echo "<h4>📝 البيانات المستخدمة حالياً:</h4>";
    echo "<ul>";
    echo "<li><strong>الخادم:</strong> $host</li>";
    echo "<li><strong>قاعدة البيانات:</strong> $dbname</li>";
    echo "<li><strong>المستخدم:</strong> $username</li>";
    echo "<li><strong>كلمات المرور المختبرة:</strong> " . implode(', ', $possiblePasswords) . "</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<div style='background:#fff3cd;padding:15px;border-radius:5px;margin:20px 0;'>";
    echo "<h4>🔧 لحل المشكلة:</h4>";
    echo "<ol>";
    echo "<li>ادخل إلى <strong>cPanel</strong> → <strong>Databases</strong></li>";
    echo "<li>تحقق من اسم قاعدة البيانات والمستخدم</li>";
    echo "<li>أنشئ كلمة مرور جديدة أو استخدم الموجودة</li>";
    echo "<li>حدث السكريبت بالبيانات الصحيحة</li>";
    echo "</ol>";
    echo "</div>";
    
    exit;
}

try {
    // التحقق من وجود المستخدم
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute(['admin@admin.com']);
    $user = $stmt->fetch();
    
    if ($user) {
        // تحديث كلمة المرور
        $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ?, email_verified_at = NOW() WHERE email = ?");
        $stmt->execute([$hashedPassword, 'admin@admin.com']);
        echo "<div style='color:green;padding:15px;background:#d4edda;border-radius:5px;margin:20px 0;'>✅ تم تحديث كلمة المرور بنجاح!</div>";
    } else {
        // إنشاء مستخدم جديد
        $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, email_verified_at, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW(), NOW())");
        $stmt->execute(['Admin', 'admin@admin.com', $hashedPassword]);
        echo "<div style='color:green;padding:15px;background:#d4edda;border-radius:5px;margin:20px 0;'>✅ تم إنشاء مستخدم إداري بنجاح!</div>";
    }
    
    // عرض المستخدمين الحاليين
    $stmt = $pdo->prepare("SELECT id, name, email, created_at FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll();
    
    echo "<div style='padding:20px;background:#f8f9fa;border:2px solid #007cba;border-radius:8px;margin:20px 0;'>";
    echo "<h3>🎯 بيانات الدخول:</h3>";
    echo "<p><strong>📧 الإيميل:</strong> <code>admin@admin.com</code></p>";
    echo "<p><strong>🔑 كلمة المرور:</strong> <code>password</code></p>";
    echo "<p><strong>🔗 رابط الإدمن:</strong> <a href='/admin' target='_blank'>https://completitcompservice.de/admin</a></p>";
    echo "</div>";
    
    echo "<div style='color:#28a745;padding:15px;background:#d4edda;border-radius:5px;margin:20px 0;'>🎉 يمكنك الآن الدخول إلى لوحة التحكم!</div>";
    
    if (count($users) > 0) {
        echo "<h3>👥 المستخدمين الحاليين:</h3>";
        echo "<table style='border-collapse:collapse;width:100%;margin:20px 0;' border='1'>";
        echo "<tr style='background:#f8f9fa;'><th>ID</th><th>الاسم</th><th>الإيميل</th><th>تاريخ الإنشاء</th></tr>";
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
    
} catch(PDOException $e) {
    echo "<div style='color:#dc3545;padding:15px;background:#f8d7da;border-radius:5px;margin:20px 0;'>❌ خطأ في العمليات: " . $e->getMessage() . "</div>";
}
?> 
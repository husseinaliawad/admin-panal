<?php
// حل سريع لإنشاء مستخدم إداري
echo "<h2>🔧 إنشاء مستخدم إداري - حل سريع</h2>";

// الاتصال بقاعدة البيانات
$host = 'localhost';
$dbname = 'u580601183_cicsdb'; // اسم قاعدة البيانات
$username = 'u580601183_cics'; // اسم المستخدم
$password = 'Hussein@123'; // كلمة المرور

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
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
    
    echo "<div style='padding:20px;background:#f8f9fa;border:2px solid #007cba;border-radius:8px;margin:20px 0;'>";
    echo "<h3>🎯 بيانات الدخول:</h3>";
    echo "<p><strong>📧 الإيميل:</strong> <code>admin@admin.com</code></p>";
    echo "<p><strong>🔑 كلمة المرور:</strong> <code>password</code></p>";
    echo "<p><strong>🔗 رابط الإدمن:</strong> <a href='/admin' target='_blank'>https://completitcompservice.de/admin</a></p>";
    echo "</div>";
    
    echo "<div style='color:#28a745;padding:15px;background:#d4edda;border-radius:5px;margin:20px 0;'>🎉 يمكنك الآن الدخول إلى لوحة التحكم!</div>";
    
} catch(PDOException $e) {
    echo "<div style='color:#dc3545;padding:15px;background:#f8d7da;border-radius:5px;margin:20px 0;'>❌ خطأ: " . $e->getMessage() . "</div>";
    echo "<div style='color:#856404;padding:15px;background:#fff3cd;border-radius:5px;margin:20px 0;'>💡 تأكد من إعدادات قاعدة البيانات في الأعلى</div>";
}
?> 
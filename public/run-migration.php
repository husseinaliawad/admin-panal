<?php
/**
 * Migration يدوي لإضافة حقل is_admin
 */

echo "<h2>🔄 تشغيل Migration - إضافة حقل is_admin</h2>";
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
    
    echo "<div class='success'>✅ تم الاتصال بقاعدة البيانات بنجاح!</div>";
    
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
    
} catch(PDOException $e) {
    echo "<div class='error'>❌ خطأ في قاعدة البيانات: " . $e->getMessage() . "</div>";
}
?>

<hr>
<div class="info">
    <h3>🎯 الخطوات التالية:</h3>
    <ol>
        <li>تأكد من أن عمود is_admin تم إضافته بنجاح</li>
        <li>اذهب إلى <a href="make-me-admin.php">make-me-admin.php</a> لجعل نفسك مشرف</li>
        <li>جرب الدخول للأدمن بانل: <a href="/admin">/admin</a></li>
        <li>احذف هذا الملف بعد الانتهاء!</li>
    </ol>
</div> 
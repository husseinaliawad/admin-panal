<?php
/**
 * أداة إدارة المشرفين - لإضافة وإزالة صلاحيات المشرف
 */

echo "<h2>👑 إدارة المشرفين</h2>";
echo "<style>
body{font-family:Arial;margin:40px;direction:rtl;} 
.success{color:green;} 
.error{color:red;} 
.info{color:blue;}
.form-section{background:#f5f5f5;padding:20px;border-radius:8px;margin:20px 0;}
.btn{background:#007cba;color:white;padding:10px 20px;border:none;border-radius:4px;cursor:pointer;margin:5px;}
.btn:hover{background:#005a8b;}
.btn-danger{background:#dc3545;}
.btn-danger:hover{background:#c82333;}
table{width:100%;border-collapse:collapse;margin:20px 0;}
th,td{border:1px solid #ddd;padding:8px;text-align:right;}
th{background:#f8f9fa;}
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
    
    // معالجة الطلبات
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['make_admin'])) {
            $userId = $_POST['user_id'];
            $stmt = $pdo->prepare("UPDATE users SET is_admin = 1 WHERE id = ?");
            $stmt->execute([$userId]);
            echo "<div class='success'>✅ تم منح صلاحيات المشرف للمستخدم!</div>";
        }
        
        if (isset($_POST['remove_admin'])) {
            $userId = $_POST['user_id'];
            $stmt = $pdo->prepare("UPDATE users SET is_admin = 0 WHERE id = ?");
            $stmt->execute([$userId]);
            echo "<div class='success'>✅ تم إزالة صلاحيات المشرف من المستخدم!</div>";
        }
        
        if (isset($_POST['create_admin'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_admin, created_at, updated_at) VALUES (?, ?, ?, 1, NOW(), NOW())");
            $stmt->execute([$name, $email, $password]);
            echo "<div class='success'>✅ تم إنشاء مستخدم مشرف جديد!</div>";
        }
    }
    
    // عرض جميع المستخدمين
    $stmt = $pdo->query("SELECT id, name, email, is_admin, created_at FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>👥 المستخدمين الحاليين:</h3>";
    echo "<table>";
    echo "<tr><th>ID</th><th>الاسم</th><th>الإيميل</th><th>مشرف؟</th><th>تاريخ الإنشاء</th><th>الإجراءات</th></tr>";
    
    foreach ($users as $user) {
        $isAdmin = $user['is_admin'] ? '✅ نعم' : '❌ لا';
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td>{$user['name']}</td>";
        echo "<td>{$user['email']}</td>";
        echo "<td>$isAdmin</td>";
        echo "<td>{$user['created_at']}</td>";
        echo "<td>";
        
        if ($user['is_admin']) {
            echo "<form method='POST' style='display:inline;'>
                    <input type='hidden' name='user_id' value='{$user['id']}'>
                    <button type='submit' name='remove_admin' class='btn btn-danger'>إزالة المشرف</button>
                  </form>";
        } else {
            echo "<form method='POST' style='display:inline;'>
                    <input type='hidden' name='user_id' value='{$user['id']}'>
                    <button type='submit' name='make_admin' class='btn'>جعل مشرف</button>
                  </form>";
        }
        
        echo "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
} catch(PDOException $e) {
    echo "<div class='error'>❌ خطأ في قاعدة البيانات: " . $e->getMessage() . "</div>";
}
?>

<div class="form-section">
    <h3>➕ إنشاء مشرف جديد</h3>
    <form method="POST">
        <div style="margin-bottom:15px;">
            <label>الاسم:</label>
            <input type="text" name="name" required style="width:200px;padding:5px;margin:0 10px;">
        </div>
        
        <div style="margin-bottom:15px;">
            <label>الإيميل:</label>
            <input type="email" name="email" required style="width:200px;padding:5px;margin:0 10px;">
        </div>
        
        <div style="margin-bottom:15px;">
            <label>كلمة المرور:</label>
            <input type="password" name="password" required style="width:200px;padding:5px;margin:0 10px;">
        </div>
        
        <button type="submit" name="create_admin" class="btn">👑 إنشاء مشرف</button>
    </form>
</div>

<hr>
<div class="info">
    <h3>🔧 كيفية الاستخدام:</h3>
    <ul>
        <li>يمكنك جعل أي مستخدم مشرف بالضغط على "جعل مشرف"</li>
        <li>يمكنك إزالة صلاحيات المشرف بالضغط على "إزالة المشرف"</li>
        <li>يمكنك إنشاء مشرف جديد من الأسفل</li>
        <li>فقط المستخدمين الذين is_admin = 1 يمكنهم الوصول للأدمن بانل</li>
    </ul>
    
    <p><strong>⚠️ احذف هذا الملف بعد الانتهاء من الإعداد!</strong></p>
</div> 
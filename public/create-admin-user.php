<?php
/**
 * إنشاء مستخدم الإدارة - Admin User Creation
 */
echo "<h2>🔐 إنشاء مستخدم الإدارة</h2>";
echo "<style>
body{font-family:Arial;margin:40px;background:#f8f9fa;} 
.success{color:#28a745;background:#d4edda;padding:15px;border-radius:5px;margin:10px 0;border:1px solid #c3e6cb;} 
.error{color:#dc3545;background:#f8d7da;padding:15px;border-radius:5px;margin:10px 0;border:1px solid #f5c6cb;} 
.info{color:#17a2b8;background:#d1ecf1;padding:15px;border-radius:5px;margin:10px 0;border:1px solid #bee5eb;}
.warning{color:#856404;background:#fff3cd;padding:15px;border-radius:5px;margin:10px 0;border:1px solid #ffeaa7;}
.btn{background:#007cba;color:white;padding:12px 24px;border:none;border-radius:4px;cursor:pointer;text-decoration:none;display:inline-block;margin:10px 0;font-size:16px;}
.btn:hover{background:#005a8b;}
.credentials{background:#f8f9fa;padding:20px;border-radius:8px;border:2px solid #007cba;margin:20px 0;}
</style>";

// تضمين إعدادات Laravel
try {
    require_once __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
} catch (Exception $e) {
    echo "<div class='error'>❌ خطأ في تحميل Laravel: " . $e->getMessage() . "</div>";
    exit;
}

// معالجة إنشاء المستخدم
if (isset($_POST['create_admin'])) {
    try {
        // التحقق من وجود المستخدم
        $existingUser = DB::table('users')->where('email', 'admin@admin.com')->first();
        
        if ($existingUser) {
            echo "<div class='warning'>⚠️ المستخدم موجود بالفعل! سيتم تحديث كلمة المرور.</div>";
            
            // تحديث كلمة المرور
            DB::table('users')
                ->where('email', 'admin@admin.com')
                ->update([
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                    'updated_at' => now()
                ]);
            
            echo "<div class='success'>✅ تم تحديث كلمة المرور بنجاح!</div>";
        } else {
            // إنشاء مستخدم جديد
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            echo "<div class='success'>✅ تم إنشاء مستخدم الإدارة بنجاح!</div>";
        }
        
        // عرض بيانات الدخول
        echo "<div class='credentials'>";
        echo "<h3>🎯 بيانات الدخول:</h3>";
        echo "<p><strong>📧 الإيميل:</strong> <code>admin@admin.com</code></p>";
        echo "<p><strong>🔑 كلمة المرور:</strong> <code>password</code></p>";
        echo "<p><strong>🔗 رابط الإدمن:</strong> <a href='/admin' target='_blank'>https://completitcompservice.de/admin</a></p>";
        echo "</div>";
        
        echo "<div class='success'>🎉 يمكنك الآن الدخول إلى لوحة التحكم!</div>";
        
    } catch (Exception $e) {
        echo "<div class='error'>❌ خطأ في إنشاء المستخدم: " . $e->getMessage() . "</div>";
    }
} else {
    // عرض النموذج
    echo "<div class='info'>📝 سيتم إنشاء مستخدم إداري بالبيانات التالية:</div>";
    echo "<ul>";
    echo "<li><strong>الاسم:</strong> Admin</li>";
    echo "<li><strong>الإيميل:</strong> admin@admin.com</li>";
    echo "<li><strong>كلمة المرور:</strong> password</li>";
    echo "</ul>";
    
    echo "<div class='warning'>⚠️ إذا كان المستخدم موجود، سيتم تحديث كلمة المرور فقط.</div>";
    
    echo "<form method='POST'>";
    echo "<button type='submit' name='create_admin' class='btn'>🔐 إنشاء مستخدم الإدارة</button>";
    echo "</form>";
}

// عرض المستخدمين الحاليين
echo "<h3>👥 المستخدمين الحاليين:</h3>";
try {
    $users = DB::table('users')->select('id', 'name', 'email', 'created_at')->get();
    
    if ($users->count() > 0) {
        echo "<table border='1' style='border-collapse:collapse;width:100%;margin:20px 0;'>";
        echo "<tr style='background:#f8f9fa;'><th>ID</th><th>الاسم</th><th>الإيميل</th><th>تاريخ الإنشاء</th></tr>";
        
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user->id}</td>";
            echo "<td>{$user->name}</td>";
            echo "<td>{$user->email}</td>";
            echo "<td>{$user->created_at}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='info'>ℹ️ لا يوجد مستخدمين في قاعدة البيانات حالياً.</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ خطأ في عرض المستخدمين: " . $e->getMessage() . "</div>";
}

echo "<hr>";
echo "<div class='info'>🎯 <strong>خطوات ما بعد الإنشاء:</strong></div>";
echo "<ol>";
echo "<li>انتظر حتى تظهر رسالة النجاح</li>";
echo "<li>افتح رابط الإدمن: <a href='/admin' target='_blank'>https://completitcompservice.de/admin</a></li>";
echo "<li>استخدم البيانات: admin@admin.com / password</li>";
echo "<li>احذف هذا الملف بعد الانتهاء!</li>";
echo "</ol>";
?> 
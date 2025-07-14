<?php
/**
 * إصلاح صلاحية الوصول للإدمن
 * Fix Admin Access to Filament Panel
 */
echo "<h2>🔧 إصلاح صلاحية الوصول للإدمن</h2>";
echo "<style>
body{font-family:Arial;margin:40px;background:#f8f9fa;direction:rtl;} 
.success{color:#28a745;background:#d4edda;padding:15px;border-radius:5px;margin:10px 0;} 
.error{color:#dc3545;background:#f8d7da;padding:15px;border-radius:5px;margin:10px 0;} 
.info{color:#17a2b8;background:#d1ecf1;padding:15px;border-radius:5px;margin:10px 0;}
.warning{color:#856404;background:#fff3cd;padding:15px;border-radius:5px;margin:10px 0;}
.btn{background:#007cba;color:white;padding:12px 24px;border:none;border-radius:4px;cursor:pointer;margin:10px 0;}
.btn:hover{background:#005a8b;}
code{background:#f1f1f1;padding:2px 5px;border-radius:3px;}
</style>";

echo "<div class='warning'>🎯 <strong>المشكلة المكتشفة:</strong><br>";
echo "ملف User.php يسمح فقط للمستخدم queen2026@gmail.com بالدخول للإدمن.<br>";
echo "نحتاج إضافة admin@admin.com للمستخدمين المسموح لهم.</div>";

$userModelPath = __DIR__ . '/../app/Models/User.php';

if (isset($_POST['fix_access'])) {
    try {
        if (!file_exists($userModelPath)) {
            throw new Exception("ملف User.php غير موجود في المسار المتوقع");
        }
        
        $content = file_get_contents($userModelPath);
        
        // البحث عن الفنكشن الحالي وتحديثه
        $oldFunction = "public function canAccessFilament(): bool\n    {\n        return \$this->email === 'queen2026@gmail.com';\n    }";
        
        $newFunction = "public function canAccessFilament(): bool\n    {\n        return in_array(\$this->email, [\n            'queen2026@gmail.com',\n            'admin@admin.com'\n        ]);\n    }";
        
        if (strpos($content, "return \$this->email === 'queen2026@gmail.com';") !== false) {
            $content = str_replace(
                "return \$this->email === 'queen2026@gmail.com';",
                "return in_array(\$this->email, [\n            'queen2026@gmail.com',\n            'admin@admin.com'\n        ]);",
                $content
            );
            
            if (file_put_contents($userModelPath, $content)) {
                echo "<div class='success'>✅ تم تحديث ملف User.php بنجاح!</div>";
                echo "<div class='success'>🎉 الآن يمكن للمستخدم admin@admin.com الدخول للإدمن!</div>";
                
                echo "<div style='padding:20px;background:#f8f9fa;border:2px solid #007cba;border-radius:8px;margin:20px 0;'>";
                echo "<h3>🎯 جرب الدخول الآن:</h3>";
                echo "<p><strong>📧 الإيميل:</strong> <code>admin@admin.com</code></p>";
                echo "<p><strong>🔑 كلمة المرور:</strong> <code>password</code></p>";
                echo "<p><strong>🔗 رابط الإدمن:</strong> <a href='/admin' target='_blank' style='color:#007cba;'>https://completitcompservice.de/admin</a></p>";
                echo "</div>";
                
            } else {
                throw new Exception("فشل في كتابة الملف - تحقق من صلاحيات الكتابة");
            }
        } else {
            echo "<div class='info'>ℹ️ الملف يبدو محدث بالفعل أو يحتوي على إعدادات مختلفة.</div>";
            
            // عرض محتوى الفنكشن الحالي
            preg_match('/public function canAccessFilament\(\): bool\s*\{[^}]+\}/', $content, $matches);
            if ($matches) {
                echo "<div class='info'>";
                echo "<h4>📝 الفنكشن الحالي:</h4>";
                echo "<pre style='background:#f8f9fa;padding:10px;border-radius:5px;overflow-x:auto;'>" . htmlspecialchars($matches[0]) . "</pre>";
                echo "</div>";
            }
        }
        
    } catch (Exception $e) {
        echo "<div class='error'>❌ خطأ: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
    
} else {
    echo "<div class='info'>";
    echo "<h3>📋 ما سيتم عمله:</h3>";
    echo "<ol>";
    echo "<li>قراءة ملف <code>app/Models/User.php</code></li>";
    echo "<li>البحث عن فنكشن <code>canAccessFilament()</code></li>";
    echo "<li>إضافة <code>admin@admin.com</code> للمستخدمين المسموح لهم</li>";
    echo "<li>حفظ التحديث</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<form method='POST'>";
    echo "<button type='submit' name='fix_access' class='btn'>🔧 إصلاح صلاحية الوصول</button>";
    echo "</form>";
}

echo "<hr>";
echo "<div class='info'>";
echo "<h4>🎯 بعد الإصلاح:</h4>";
echo "<p>1. جرب الدخول إلى: <a href='/admin' target='_blank' style='color:#007cba;'>https://completitcompservice.de/admin</a></p>";
echo "<p>2. استخدم البيانات: <code>admin@admin.com</code> / <code>password</code></p>";
echo "<p>3. إذا نجح الدخول، احذف ملفات الإصلاح</p>";
echo "</div>";
?> 
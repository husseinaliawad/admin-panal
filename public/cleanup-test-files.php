<?php
/**
 * تنظيف ملفات الاختبار بعد التأكد من عمل الحل
 */
echo "<h2>🧹 تنظيف ملفات الاختبار</h2>";
echo "<style>
body{font-family:Arial;margin:40px;background:#f8f9fa;} 
.success{color:#28a745;background:#d4edda;padding:10px;border-radius:5px;margin:10px 0;} 
.error{color:#dc3545;background:#f8d7da;padding:10px;border-radius:5px;margin:10px 0;} 
.info{color:#17a2b8;background:#d1ecf1;padding:10px;border-radius:5px;margin:10px 0;}
.btn{background:#007cba;color:white;padding:10px 20px;border:none;border-radius:4px;cursor:pointer;text-decoration:none;display:inline-block;margin:10px 0;}
.btn:hover{background:#005a8b;}
.danger{background:#dc3545;}
.danger:hover{background:#bd2130;}
</style>";

if (isset($_POST['cleanup'])) {
    echo "<h3>🗑️ حذف ملفات الاختبار...</h3>";
    
    $testFiles = [
        'test-images.php',
        'update-brand-paths.php',
        'cleanup-test-files.php' // هذا الملف نفسه
    ];
    
    foreach ($testFiles as $file) {
        if (file_exists($file)) {
            if (unlink($file)) {
                echo "<div class='success'>✅ تم حذف: $file</div>";
            } else {
                echo "<div class='error'>❌ فشل حذف: $file</div>";
            }
        } else {
            echo "<div class='info'>ℹ️ الملف غير موجود: $file</div>";
        }
    }
    
    echo "<div class='success'>✅ تم تنظيف جميع ملفات الاختبار!</div>";
    echo "<a href='/' class='btn'>🏠 العودة للصفحة الرئيسية</a>";
    
} else {
    echo "<div class='info'>🎯 <strong>ملفات الاختبار المراد حذفها:</strong></div>";
    echo "<ul>";
    echo "<li>test-images.php</li>";
    echo "<li>update-brand-paths.php</li>";
    echo "<li>cleanup-test-files.php</li>";
    echo "</ul>";
    
    echo "<div class='error'>⚠️ تأكد من اختبار الموقع قبل حذف هذه الملفات!</div>";
    
    echo "<h3>📋 قائمة التحقق:</h3>";
    echo "<ul>";
    echo "<li>✅ هل صور العلامات التجارية تظهر في الصفحة الرئيسية؟</li>";
    echo "<li>✅ هل الروابط تعمل بشكل صحيح؟</li>";
    echo "<li>✅ هل تم اختبار الموقع على الخادم المباشر؟</li>";
    echo "</ul>";
    
    echo "<form method='POST'>";
    echo "<button type='submit' name='cleanup' class='btn danger'>🗑️ حذف ملفات الاختبار</button>";
    echo "</form>";
}
?> 
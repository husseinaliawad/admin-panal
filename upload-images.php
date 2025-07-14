<?php
/**
 * أداة رفع الصور مباشرة إلى public/storage
 */

echo "<h2>📸 رفع الصور - أداة مباشرة</h2>";
echo "<style>
body{font-family:Arial;margin:40px;} 
.success{color:green;} 
.error{color:red;} 
.info{color:blue;}
.upload-form{background:#f5f5f5;padding:20px;border-radius:8px;margin:20px 0;}
.btn{background:#007cba;color:white;padding:10px 20px;border:none;border-radius:4px;cursor:pointer;}
.btn:hover{background:#005a8b;}
</style>";

// معالجة رفع الصور
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $uploadedFile = $_FILES['image'];
    $category = $_POST['category'] ?? 'images';
    
    if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
        $filename = time() . '_' . $uploadedFile['name'];
        $destination = "public/storage/$category/$filename";
        
        // إنشاء المجلد إذا لم يكن موجود
        $dir = dirname($destination);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        if (move_uploaded_file($uploadedFile['tmp_name'], $destination)) {
            echo "<div class='success'>✅ تم رفع الصورة بنجاح: $filename</div>";
            echo "<p>الرابط: <a href='/storage/$category/$filename' target='_blank'>/storage/$category/$filename</a></p>";
        } else {
            echo "<div class='error'>❌ فشل في رفع الصورة</div>";
        }
    } else {
        echo "<div class='error'>❌ خطأ في الملف المرفوع</div>";
    }
}

?>

<div class="upload-form">
    <h3>📤 رفع صورة جديدة</h3>
    <form method="POST" enctype="multipart/form-data">
        <div style="margin-bottom:15px;">
            <label>اختر الفئة:</label>
            <select name="category" style="margin-left:10px;padding:5px;">
                <option value="brands">العلامات التجارية (Brands)</option>
                <option value="categories">الفئات (Categories)</option>
                <option value="products">المنتجات (Products)</option>
                <option value="images">صور عامة (Images)</option>
            </select>
        </div>
        
        <div style="margin-bottom:15px;">
            <label>اختر الصورة:</label>
            <input type="file" name="image" accept="image/*" required style="margin-left:10px;">
        </div>
        
        <button type="submit" class="btn">📤 رفع الصورة</button>
    </form>
</div>

<h3>📁 الصور الحالية:</h3>

<?php
$folders = ['brands', 'categories', 'products', 'images'];
foreach ($folders as $folder) {
    $folderPath = "public/storage/$folder";
    if (is_dir($folderPath)) {
        echo "<h4>📂 $folder:</h4>";
        $files = array_diff(scandir($folderPath), ['.', '..']);
        if (!empty($files)) {
            echo "<ul>";
            foreach ($files as $file) {
                echo "<li><a href='/storage/$folder/$file' target='_blank'>$file</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='info'>لا توجد صور في هذا المجلد</p>";
        }
    }
}
?>

<hr>
<p class='info'>🎯 <strong>ملاحظات مهمة:</strong></p>
<ul>
    <li>الصور يتم رفعها مباشرة إلى public/storage/</li>
    <li>لا حاجة لـ symlink أو storage:link</li>
    <li>يمكن الوصول للصور مباشرة عبر /storage/folder/filename</li>
    <li>احذف هذا الملف بعد الانتهاء!</li>
</ul> 
<?php
/**
 * 🔧 اختبار قواعد إعادة التوجيه
 * هذه الأداة تختبر إعادة التوجيه من /public/ إلى /
 */

echo "<h1>🔧 اختبار قواعد إعادة التوجيه</h1>";
echo "<style>
body{font-family:Arial;margin:40px;} 
.success{color:green;} 
.error{color:red;} 
.info{color:blue;}
.warning{color:orange;}
.test-section{background:#f5f5f5;padding:20px;border-radius:8px;margin:20px 0;}
.test-link{display:block;margin:10px 0;padding:10px;background:#e8f4f8;border-radius:5px;text-decoration:none;color:#333;}
.test-link:hover{background:#d1ecf1;}
</style>";

// تحديد عنوان الموقع
$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];

echo "<div class='test-section'>";
echo "<h2>🌐 اختبار إعادة التوجيه من /public/ إلى /</h2>";
echo "<p class='info'>انقر على الروابط أدناه لاختبار إعادة التوجيه:</p>";

$testUrls = [
    'public/categories/' => 'categories/',
    'public/products/' => 'products/',
    'public/brands/' => 'brands/',
    'public/admin/' => 'admin/',
    'public/cart/' => 'cart/',
];

foreach ($testUrls as $wrongUrl => $correctUrl) {
    echo "<a href='$baseUrl/$wrongUrl' class='test-link' target='_blank'>";
    echo "🔗 $wrongUrl → $correctUrl";
    echo "</a>";
}
echo "</div>";

echo "<div class='test-section'>";
echo "<h2>🖼️ اختبار إعادة توجيه الصور</h2>";
$imageTests = [
    'public/categories/test-category.jpg' => 'categories/test-category.jpg',
    'public/brands/test-brand.jpg' => 'brands/test-brand.jpg',
    'public/products/test-product.jpg' => 'products/test-product.jpg',
    'storage/categories/test-category.jpg' => 'categories/test-category.jpg',
    'storage/brands/test-brand.jpg' => 'brands/test-brand.jpg',
];

foreach ($imageTests as $wrongUrl => $correctUrl) {
    echo "<a href='$baseUrl/$wrongUrl' class='test-link' target='_blank'>";
    echo "🖼️ $wrongUrl → $correctUrl";
    echo "</a>";
}
echo "</div>";

echo "<div class='test-section'>";
echo "<h2>✅ اختبار الروابط الصحيحة</h2>";
$correctUrls = [
    'categories/',
    'products/',
    'brands/',
    'admin/',
    'cart/',
];

foreach ($correctUrls as $url) {
    echo "<a href='$baseUrl/$url' class='test-link' target='_blank'>";
    echo "✅ $url";
    echo "</a>";
}
echo "</div>";

echo "<div class='test-section'>";
echo "<h2>🎯 النتيجة المتوقعة</h2>";
echo "<ul>";
echo "<li>🔄 الروابط الخاطئة يجب أن تعيد التوجيه تلقائياً</li>";
echo "<li>✅ الروابط الصحيحة يجب أن تعمل مباشرة</li>";
echo "<li>🖼️ الصور يجب أن تظهر بشكل صحيح</li>";
echo "<li>📱 لا يجب رؤية /public/ في شريط العنوان</li>";
echo "</ul>";
echo "</div>";

echo "<div class='test-section'>";
echo "<h2>📋 إعدادات الخادم</h2>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Current Directory: " . __DIR__ . "</p>";
echo "<p>Request URI: " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p>HTTP Host: " . $_SERVER['HTTP_HOST'] . "</p>";
echo "</div>";

?> 

# 📦 تعليمات الرفع للخادم

## الملفات المحدثة:
- public/.htaccess (قواعد إعادة التوجيه)
- config/filesystems.php (إعدادات الأقراص)
- app/Filament/Resources/ (موارد Filament)
- app/Helpers/ImageHelper.php (مساعد الصور)

## المجلدات المطلوبة:
- public/brands/
- public/categories/
- public/products/
- public/images-/

## خطوات الرفع:
1. ارفع جميع الملفات في مجلد upload-ready
2. تأكد من أن المجلدات لها صلاحيات 755
3. اختبر الروابط:
   - https://yoursite.com/brands/
   - https://yoursite.com/categories/
   - https://yoursite.com/products/

## اختبار إعادة التوجيه:
- https://yoursite.com/public/categories/ → https://yoursite.com/categories/
- https://yoursite.com/storage/brands/ → https://yoursite.com/brands/

## ملاحظات:
- احذف test-images-final.php بعد الاختبار
- احذف prepare-upload.php بعد الرفع
- احذف upload-ready/ بعد الانتهاء

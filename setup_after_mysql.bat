@echo off
echo ========================================
echo        Laravel MySQL Setup Script
echo ========================================
echo.

echo Clearing Laravel configuration cache...
php artisan config:clear

echo.
echo Running database migrations...
php artisan migrate:fresh --seed

echo.
echo Creating admin user...
php artisan tinker --execute="App\Models\User::create(['name' => 'Admin', 'email' => 'admin@admin.com', 'password' => Hash::make('password'), 'email_verified_at' => now()]);"

echo.
echo Creating sample categories...
php artisan tinker --execute="App\Models\Category::create(['name' => 'Electronics', 'slug' => 'electronics', 'image' => 'categories/electronics.jpg', 'is_active' => 1]);"
php artisan tinker --execute="App\Models\Category::create(['name' => 'Fashion', 'slug' => 'fashion', 'image' => 'categories/fashion.jpg', 'is_active' => 1]);"

echo.
echo Creating sample brands...
php artisan tinker --execute="App\Models\Brand::create(['name' => 'Apple', 'slug' => 'apple', 'image' => 'brands/apple.jpg', 'is_active' => 1]);"
php artisan tinker --execute="App\Models\Brand::create(['name' => 'Samsung', 'slug' => 'samsung', 'image' => 'brands/samsung.jpg', 'is_active' => 1]);"

echo.
echo ========================================
echo            Setup Complete!
echo ========================================
echo.
echo Admin Login:
echo Email: admin@admin.com
echo Password: password
echo.
echo URLs:
echo Main Site: http://127.0.0.1:8000
echo Admin Panel: http://127.0.0.1:8000/admin
echo.
echo To start the server, run: php artisan serve
echo.
pause 
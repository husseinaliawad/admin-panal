<?php

use App\Http\Livewire\Auth\ForgotPasswordPage;
use App\Http\Livewire\Auth\LoginPage;
use App\Http\Livewire\Auth\RegisterPage;
use App\Http\Livewire\Auth\ResetPasswordPage;
use App\Http\Livewire\CancelPage;
use App\Http\Livewire\CartPage;
use App\Http\Livewire\CategoriesPage;
use App\Http\Livewire\CheckoutPage;
use App\Http\Livewire\ProductDetailPage;
use App\Http\Livewire\ProductsPage;
use App\Http\Livewire\HomePage;
use App\Http\Livewire\MyorderDetailPage;
use App\Http\Livewire\MyordersPage;
use App\Http\Livewire\ServicePage;
use App\Http\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomePage::class);
Route::get('/categories', CategoriesPage::class);
Route::get('/products', ProductsPage::class);
Route::get('/cart', CartPage::class);
Route::get('/products/{slug}', ProductDetailPage::class);
// Route::get('/checkout', CheckoutPage::class);
// Route::get('/my-orders', MyordersPage::class);
// Route::get('/my-orders/{order}', MyorderDetailPage::class);

// لا حاجة لـ serve.image route بعد الآن
// الصور موجودة مباشرة في public/storage/








Route::middleware('guest')->group(function(){
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class);
    Route::get('/forgot', ForgotPasswordPage::class)->name('password.request');
    Route::get('/reset{token}', ResetPasswordPage::class)->name('password.reset');
});



Route::middleware('auth')->group(function(){

    Route::get('/logout',function(){
        auth()->logout();
        return redirect('/');
    });

    Route::get('/checkout', CheckoutPage::class);
    Route::get('/my-orders', MyordersPage::class);
    Route::get('/my-orders/{order_id}', MyorderDetailPage::class)->name('my-orders.show');
    Route::get('/success', SuccessPage::class)->name('success');
    Route::get('/cancel', CancelPage::class)->name('cancel');
});




Route::view('/datenschutz', 'company.datenschutz')->name('privacy');
Route::get('/service', ServicePage::class)->name('service');


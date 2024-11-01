<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ContactUsController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\VariantController; 
use App\Http\Controllers\Web\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutConroller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::controller(HomeController::class)->group(function(){
    Route::get('/','index')->name('home');
    Route::get('changeLanguage', 'changeLanguage')->name('changeLanguage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/add-address', [ProfileController::class, 'addAddress'])->name('add-address');
    Route::post('/add-phone', [ProfileController::class, 'addPhoneNumber'])->name('add-phone');

    Route::controller(WishlistController::class)->group(function(){
        Route::get('wishlists', 'index')->name('wishlists');
        Route::post('wishlist', 'store')->name('add-wishlist');
        Route::delete('wishlist/{id}', 'destroy')->name('destroy-wishlist');
    });

    Route::controller(CheckoutConroller::Class)->group(function(){
        Route::get('checkout', 'get')->name('checkout');
        Route::post('checkout', 'checkout');
    });
    
});

Route::prefix('cart')->controller(CartController::Class)->group(function(){
    Route::get('/', 'get')->name('cart');
    Route::post('add-product', 'addProduct')->name('add-product');
    Route::delete('delete-product/{product_id}', 'removeProduct')->name('removeProduct');
    Route::patch('increment-quantity','incrementQuantity')->name('increment-quantity');
    Route::patch('decrement-quantity', 'decrementQuantity')->name('decrement-quantity');
});

Route::prefix('products')->controller(ProductController::class)->group(function(){
    Route::get('increment-view/{id}', 'incrementViews');
    Route::get('/', 'index')->name('get-product');
});

Route::get('variant/{id}', [VariantController::Class, 'get']);

Route::post('contact-us', [ContactUsController::class, 'create'])->name('contactUs');

Route::get('variants/{id}', [VariantController::Class, 'get']);

Route::get('/t', function(){
    return view('mails.order');
});

require __DIR__.'/auth.php';
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ContactUsController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\VariantController; 
use App\Http\Controllers\Web\WishlistController;
use App\Http\Controllers\ProfileController;

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

    Route::controller(WishlistController::class)->group(function(){
        Route::get('wishlists', 'index')->name('wishlists');
        Route::post('wishlist', 'store')->name('add-wishlist');
        Route::delete('wishlist/{id}', 'destroy')->name('destroy-wishlist');
    });
});


Route::prefix('products')->controller(ProductController::class)->group(function(){
    Route::get('increment-view/{id}', 'incrementViews');
    Route::get('/', 'index')->name('get-product');
});

Route::get('variant/{id}', [VariantController::Class, 'get']);

Route::post('contact-us', [ContactUsController::class, 'create'])->name('contactUs');

Route::get('/t', function(){
    $t = \App\Models\Variant::with('subOptions')->with('subOptions.option')->find(6);

    $p = \App\Models\Product::with(['variants', 'variants.subOptions', 'variants.subOptions.option'])
        ->get();
    
    $c = \App\Models\Category::where('name->en', 'Flavoured')->first();
    return $c;
});

Route::get('variants/{id}', [VariantController::Class, 'get']);

require __DIR__.'/auth.php';
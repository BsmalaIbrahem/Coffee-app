<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ContactUsController;

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

Route::post('contact-us', [ContactUsController::class, 'create'])->name('contactUs');

Route::get('/t');

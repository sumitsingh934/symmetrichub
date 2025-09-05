<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\EnquiryController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/contact-us', [EnquiryController::class, 'index'])->name('contact_us');
Route::post('/contact-store', [EnquiryController::class, 'store'])->name('contact.store');

Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::get('/register', [UserAuthController::class, 'register'])->name('register');
    Route::post('/register', [UserAuthController::class, 'store']);
    Route::get('/user-register/{ref}', [UserAuthController::class, 'showReferral'])->name('user.refferal');
    Route::get('/get-course-prices/{id}', [UserAuthController::class, 'getPrices'])->name('get-course-prices');

    Route::post('/validate-coupon', [UserAuthController::class, 'validateCoupon'])->name('coupon.validate');

});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/user/dashboard', [UserAuthController::class, 'user_dashboard'])->name('user_dashboard');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

});

require __DIR__.'/../routes/admin.php';


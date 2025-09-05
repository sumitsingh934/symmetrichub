<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DiscountController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('admin.auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        Route::get('profile/edit/{id}', [AdminController::class, 'editProfile'])->name('profile.edit');
        Route::post('/admin/{id}', [AdminController::class, 'update'])->name('update');



    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index')->name('users.index');
        Route::post('/user/list', 'user_list')->name('users.user_list');
        Route::get('/user-create', 'create')->name('users.create');
        Route::post('/user-create', 'store')->name('users.store');
        Route::get('user/show/{id}', 'show')->name('users.show');
        Route::get('user/edit/{id}', 'edit')->name('users.edit');
        Route::post('user/update/{id}', 'update')->name('users.update');
        Route::delete('/user/{id}', 'destroy')->name('users.destroy');
        Route::post('/user/{id}/toggle-status', 'toggleStatus')->name('users.toggle-status');
      
    });

    Route::controller(PlanController::class)->group(function () {
        Route::get('/plan', 'index')->name('plan.index');
        Route::post('/plan/list', 'plan_list')->name('plan.plan_list');
        Route::get('/plan-create', 'create')->name('plan.create');
        Route::post('/plan-create', 'store')->name('plan.store');
        Route::get('plan/show/{id}', 'show')->name('plan.show');
        Route::get('plan/edit/{id}', 'edit')->name('plan.edit');
        Route::post('plan/update/{id}', 'update')->name('plan.update');
        Route::delete('/plan/{id}', 'destroy')->name('plan.destroy');
        Route::post('/plan/{id}/toggle-status',  'toggleStatus')->name('plan.toggle-status');
    });

    Route::controller(CourseController::class)->group(function () {
        Route::get('/courses', 'index')->name('courses.index');
        Route::post('/courses/list', 'course_list')->name('courses.course_list');
        Route::get('/courses-create', 'create')->name('courses.create');
        Route::post('/courses-create', 'store')->name('courses.store');
        Route::get('courses/show/{id}', 'show')->name('courses.show');
        Route::get('courses/edit/{id}', 'edit')->name('courses.edit');
        Route::post('courses/update/{id}', 'update')->name('courses.update');
        Route::delete('/courses/{id}', 'destroy')->name('courses.destroy');
        Route::post('/courses/{id}/toggle-status',  'toggleStatus')->name('courses.toggle-status');
    });
   
        Route::controller(ContactController::class)->group(function () {
        Route::get('/contact', 'index')->name('contact.index');
        Route::post('/contact/list', 'contact_list')->name('contact.contact_list');
        Route::delete('/contact/{id}', 'destroy')->name('contact.destroy');
    });

    Route::controller(DiscountController::class)->group(function () {
        Route::get('/discounts', 'index')->name('discounts.index');
        Route::post('/discounts/list', 'discount_list')->name('discounts.discount_list');
        Route::get('/discounts-create', 'create')->name('discounts.create');
        Route::post('/discounts-create', 'store')->name('discounts.store');
        Route::get('discounts/show/{id}', 'show')->name('discounts.show');
        Route::get('discounts/edit/{id}', 'edit')->name('discounts.edit');
        Route::post('discounts/update/{id}', 'update')->name('discounts.update');
        Route::delete('/discounts/{id}', 'destroy')->name('discounts.destroy');
        Route::post('/discounts/{id}/toggle-status',  'toggleStatus')->name('discounts.toggle-status');
        Route::get('/discounts/search',  'search')->name('discounts.search');

    });

    });

});


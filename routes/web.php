<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page routes
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/home', 'home')->name('home.index');

    Route::get('/about', 'about')->name('about');

    Route::get('list', 'propertyList')->name('property.list');
    Route::get('type', 'propertyType')->name('property.type');
    Route::get('agent', 'propertyAgent')->name('property.agent');

    Route::get('/contact', 'contact')->name('contact');
    Route::get('/testimonial', 'testimonial')->name('testimonial');
    Route::get('/404', 'notFound')->name('404');
});


Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::resource('properties', PropertyController::class);
    // Route::resource('users', UserController::class);
    // Route::resource('reservations', ReservationController::class);
    // Route::resource('messages', MessageController::class);
    // Route::resource('payments', PaymentController::class);
    // Route::resource('reports', ReportController::class);
    // Route::resource('settings', SettingController::class);
    // Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    // Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

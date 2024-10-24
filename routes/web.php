<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::middleware(['auth'])->group(function () {

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::resource('users', App\Http\Controllers\UserController::class);
        Route::resource('properties', App\Http\Controllers\PropertyController::class);
        Route::resource('property-images', App\Http\Controllers\PropertyImageController::class);
        Route::resource('amenities', App\Http\Controllers\AmenityController::class);
        Route::resource('property-amenities', App\Http\Controllers\PropertyAmenityController::class);
        Route::resource('reservations', App\Http\Controllers\ReservationController::class);
        Route::resource('payments', App\Http\Controllers\PaymentController::class);
        Route::resource('reviews', App\Http\Controllers\ReviewController::class);
        Route::resource('messages', App\Http\Controllers\MessageController::class);
        Route::resource('notifications', App\Http\Controllers\NotificationController::class);
        Route::resource('maintenances', App\Http\Controllers\MaintenanceController::class);
        Route::resource('documents', App\Http\Controllers\DocumentController::class);
});

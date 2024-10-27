<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
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

    Route::get('/about', 'about')->name('about');

    Route::get('list', 'propertyList')->name('property.list');
    Route::get('type', 'propertyType')->name('property.type');
    Route::get('agent', 'propertyAgent')->name('property.agent');

    Route::get('/contact', 'contact')->name('contact');
    Route::get('/testimonial', 'testimonial')->name('testimonial');
    Route::get('/404', 'notFound')->name('404');
    Route::get('allproperties', 'allproperties')->name('allproperties');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
    Route::resource('reports', ReportController::class);
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Routes pour la gestion des images
    Route::delete('/property-images/{image}', [PropertyController::class, 'deleteImage'])
    ->name('properties.delete-image');
    Route::post('/property-images/{image}/primary', [PropertyController::class, 'setPrimaryImage'])
    ->name('properties.set-primary-image');

    // Routes additionnelles pour la gestion des images
    Route::post('properties/{property}/images', [PropertyController::class, 'uploadImages'])
        ->name('properties.upload-images');
    Route::delete('properties/images/{image}', [PropertyController::class, 'deleteImage'])
        ->name('properties.delete-image');
    Route::post('properties/images/{image}/set-primary', [PropertyController::class, 'setPrimaryImage'])
        ->name('properties.set-primary-image');
         // Nouvelle route pour l'ordre des images
    Route::post('properties/{property}/update-image-order', [PropertyController::class, 'updateImageOrder'])
    ->name('properties.update-image-order');
    Route::get('properties/{property}/availability-suggestions', 
        [PropertyController::class, 'getAvailabilitySuggestions'])
        ->name('properties.availability-suggestions');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

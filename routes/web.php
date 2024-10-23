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

    // Property related routes
    Route::prefix('property')->name('property.')->group(function () {
        Route::get('/list', 'propertyList')->name('list');
        Route::get('/type', 'propertyType')->name('type');
        Route::get('/agent', 'propertyAgent')->name('agent');
    });

    Route::get('/contact', 'contact')->name('contact');
    Route::get('/testimonial', 'testimonial')->name('testimonial');
    Route::get('/404', 'notFound')->name('404');
});

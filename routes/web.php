<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/home', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});
Route::get('/property-list', function () {
    return view('property-list');
});
Route::get('/property-type', function () {
    return view('property-type');
});
Route::get('/property-agent', function () {
    return view('property-agent');
});
Route::get('/contact', function () {
    return view('contact');
});
Route::get('/testimonial', function () {
    return view('testimonial');
});
Route::get('/404', function () {
    return view('404');
});


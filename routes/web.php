<?php

use Illuminate\Support\Facades\Route;

// Route untuk halaman login
Route::get('/', function () {
    return view('auth.login');  // Pastikan file ada di resources/views/home/home.blade.php
})->name('login');

//rote untuk register
Route::get('/register', function () {
    return view('auth.register');  // Pastikan file ada di resources/views/home/home.blade.php
})->name('register');

//route untuk home
Route::get('/home', function () {
    return view('home.home');  // Pastikan file ada di resources/views/home/home.blade.php
})->name('home');

// Route untuk halaman Journaling
Route::get('/journaling', function () {
    return view('journaling.journaling'); // Pastikan file ada di resources/views/journaling/index.blade.php
})->name('journaling');




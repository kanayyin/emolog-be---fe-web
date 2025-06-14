<?php

use Illuminate\Support\Facades\Route;

// Route untuk halaman login
/*Route::get('/', function () {
    return view('auth.login');  // Pastikan file ada di resources/views/home/home.blade.php
})->name('login');*/
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLogin'])->name('showlogin');
Route::post('/', [AuthController::class, 'login'])->name('login');

//rote untuk register
Route::get('/register', function () {
    return view('auth.register');  // Pastikan file ada di resources/views/home/home.blade.php
})->name('register');
Route::post('/register', [AuthController::class, 'register']);

//route untuk home
use App\Http\Controllers\DiaryController;

Route::get('/home', [DiaryController::class, 'getWeeklyMood'])->name('home');


// Route untuk halaman Journaling
Route::get('/journaling', function () {
    return view('journaling.journaling'); 
})->name('journaling');

// Route untuk halaman Jhistory
Route::get('/history', function () {
    return view('journaling.history'); 
})->name('history');

// Route untuk halaman setting
Route::get('/setting', function () {
    return view('setting.setting');
})->name('setting');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password');
 Route::get('/diaries/day', [DiaryController::class, 'getDiariesByDay'])->name('diaries.day');

    // API untuk ambil diary berdasarkan minggu
    Route::get('/diaries/week', [DiaryController::class, 'getDiariesByWeek'])->name('diaries.week');
Route::post('/diary/create', [DiaryController::class, 'createDiary'])->name('diary.store');

Route::put('/diaries/{id}', [DiaryController::class, 'updateDiary'])->name('diary.update');
    Route::delete('/diaries/{id}', [DiaryController::class, 'deleteDiary']);
    Route::get('/diaries/{id}/edit', [DiaryController::class, 'edit'])->name('diary.edit');
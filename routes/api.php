<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiaryController;

Route::middleware(\Illuminate\Http\Middleware\HandleCors::class)->group(function () {
    // Route yang tidak perlu autentikasi
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/check-user', [AuthController::class, 'checkUser']);
});

// Group route yang butuh autentikasi token Sanctum
Route::middleware(['auth:sanctum', \Illuminate\Http\Middleware\HandleCors::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::get('/diaries/day', [DiaryController::class, 'getDiariesByDay']);
    Route::get('/diaries/week', [DiaryController::class, 'getDiariesByWeek']);
    Route::post('/diary', [DiaryController::class, 'createDiary']);
    Route::get('/moods/week', [DiaryController::class, 'getWeeklyMood']);
    Route::get('/moods/today', [DiaryController::class, 'getTodayMood']);
    Route::delete('/diary/{id}', [DiaryController::class, 'deleteDiary']);
    Route::put('/diaries/{id}', [DiaryController::class, 'updateDiary']);

});

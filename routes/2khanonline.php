<?php

use App\Http\Controllers\khanonline\AuthController;
use App\Http\Controllers\khanonline\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('2khanonline.home');
})->name('home');

Route::middleware('guest:web')->group(function () {
    Route::get('/auth', [AuthController::class, 'show'])->name('auth.show');
    Route::post('/auth/phone', [AuthController::class, 'sendOtp'])->name('auth.phone');
    Route::post('/auth/resend', [AuthController::class, 'resendOtp'])->name('auth.resend');
    Route::post('/auth/verify', [AuthController::class, 'verifyOtp'])->name('auth.verify');

    Route::get('/login', fn () => redirect()->route('auth.show'))->name('login');
});

Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});


Route::get('/about-us', [PageController::class, 'aboutUs'])->name('pages.about-us');
Route::get('/contact-us', [PageController::class, 'contactUs'])->name('pages.contact-us');

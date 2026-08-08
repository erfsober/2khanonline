<?php

use App\Http\Controllers\admin\AboutUsController;
use App\Http\Controllers\admin\ContactUsController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // About Us
        Route::prefix('about-us')->name('about-us.')->group(function () {
            Route::get('/', [AboutUsController::class, 'edit'])->name('edit');
            Route::put('/', [AboutUsController::class, 'update'])->name('update');
        });

        // Contact Us
        Route::prefix('contact-us')->name('contact-us.')->group(function () {
            Route::get('/', [ContactUsController::class, 'edit'])->name('edit');
            Route::put('/', [ContactUsController::class, 'update'])->name('update');
        });
    });
});

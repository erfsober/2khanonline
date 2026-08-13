<?php

use App\Http\Controllers\admin\AboutUsController;
use App\Http\Controllers\admin\CardController;
use App\Http\Controllers\admin\ContactUsController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\ProductBrandController;
use App\Http\Controllers\admin\ProductCategoryController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\UserController;
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

        // Product Categories
        Route::resource('product-categories', ProductCategoryController::class)->except(['show']);

        // Product Brands
        Route::resource('product-brands', ProductBrandController::class)->except(['show']);

        // Products
        Route::resource('products', ProductController::class)->except(['show']);

        // Orders
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/approve', [OrderController::class, 'approve'])->name('orders.approve');
        Route::post('orders/{order}/reject', [OrderController::class, 'reject'])->name('orders.reject');
        Route::patch('orders/{order}/shipping-status', [OrderController::class, 'updateShippingStatus'])->name('orders.update-shipping-status');

        // Users
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

        // Financial - Card
        Route::prefix('financial/card')->name('financial.card.')->group(function () {
            Route::get('/', [CardController::class, 'edit'])->name('edit');
            Route::put('/', [CardController::class, 'update'])->name('update');
        });
    });
});

<?php

use App\Http\Controllers\khanonline\AuthController;
use App\Http\Controllers\khanonline\CartController;
use App\Http\Controllers\khanonline\HomeController;
use App\Http\Controllers\khanonline\OrderController;
use App\Http\Controllers\khanonline\PageController;
use App\Http\Controllers\khanonline\PaymentController;
use App\Http\Controllers\khanonline\ProductController;
use App\Http\Controllers\khanonline\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');

Route::get('/api/search', [ProductController::class, 'search'])->name('api.search');

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

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/checkout', fn () => redirect()->route('cart.index'))->name('checkout.continue');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout.start');

    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/receipt', [PaymentController::class, 'uploadReceipt'])->name('payment.receipt');
});

// Cart routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'page'])->name('cart.index');
    Route::get('/items', [CartController::class, 'index'])->name('cart.items');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

Route::get('/about-us', [PageController::class, 'aboutUs'])->name('pages.about-us');
Route::get('/contact-us', [PageController::class, 'contactUs'])->name('pages.contact-us');

Route::get('/categories/{category:slug}', [ProductController::class, 'category'])
    ->name('categories.show');

Route::get('/brands/{brand:slug}', [ProductController::class, 'brand'])
    ->name('brands.show');

// product routes
Route::get('/{slug}', [ProductController::class, 'show'])->name('products.show');

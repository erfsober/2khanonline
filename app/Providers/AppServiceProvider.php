<?php

namespace App\Providers;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('2khanonline.layout.header', function ($view): void {
            $view->with('navigationCategories', ProductCategory::query()
                ->orderBy('id')
                ->get(['slug', 'name']));
        });
    }
}

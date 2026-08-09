<?php

namespace App\Providers;

use App\Models\ProductBrand;
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

        View::composer('2khanonline.layout.footer', function ($view): void {
            $view->with([
                'footerCategories' => ProductCategory::query()
                    ->orderBy('id')
                    ->get(['slug', 'name']),
                'footerBrands' => ProductBrand::query()
                    ->orderBy('name')
                    ->get(['slug', 'name']),
            ]);
        });
    }
}

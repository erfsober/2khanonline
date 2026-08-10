<?php

namespace App\Http\Controllers\khanonline;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index()
    {
        $primaryCategories = config('store.primary_category_slugs', []);
        $categories = ProductCategory::with(['products' => function ($query) {
            $query->orderByDesc('id');
        }])->whereIn('slug', $primaryCategories)->orderBy('id')->get();
        $products = Product::whereHas('category', function ($query) use ($primaryCategories) {
            $query->whereIn('slug', $primaryCategories);
        })->orderByDesc('id')->paginate(6);

        return view('2khanonline.home', compact('categories', 'products'));
    }
}

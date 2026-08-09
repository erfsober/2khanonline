<?php

namespace App\Http\Controllers\khanonline;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with(['products' => function ($query) {
            $query->orderByDesc('id');
        }])->orderBy('id')->limit(4)->get();
        $products = Product::orderBy('id', 'desc')->paginate(6);

        return view('2khanonline.home', compact('categories', 'products'));
    }
}

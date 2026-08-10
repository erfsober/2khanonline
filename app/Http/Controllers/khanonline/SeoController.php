<?php

namespace App\Http\Controllers\khanonline;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $categories = ProductCategory::query()
            ->whereIn('slug', config('store.primary_category_slugs', []))
            ->orderBy('id')
            ->get(['slug', 'updated_at']);
        $products = Product::query()
            ->whereHas('category', fn ($query) => $query->whereIn('slug', config('store.primary_category_slugs', [])))
            ->orderBy('id')
            ->get(['slug', 'updated_at']);

        $urls = [
            ['loc' => route('home'), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => route('pages.about-us'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('pages.contact-us'), 'changefreq' => 'monthly', 'priority' => '0.5'],
        ];

        foreach ($categories as $category) {
            $urls[] = [
                'loc' => route('categories.show', $category->slug),
                'lastmod' => $category->updated_at,
                'changefreq' => 'daily',
                'priority' => '0.8',
            ];
        }

        foreach ($products as $product) {
            $urls[] = [
                'loc' => route('products.show', $product->slug),
                'lastmod' => $product->updated_at,
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        $xml = view('seo.sitemap', compact('urls'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}

<?php

namespace App\Http\Controllers\khanonline;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::query()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => number_format($product->price),
                    'image' => $product->image_url,
                    'url' => route('products.show', $product->slug),
                ];
            });

        return response()->json($products);
    }

    public function show(string $slug): View
    {
        $productModel = 'App\\Models\\Product';

        abort_unless(class_exists($productModel), 404);

        $with = collect(['category', 'brand'])
            ->filter(fn (string $relation): bool => method_exists($productModel, $relation))
            ->values()
            ->all();

        $product = $productModel::query()
            ->when($with !== [], fn ($query) => $query->with($with))
            ->where('slug', $slug)
            ->firstOrFail();

        $unitPrice = $this->firstNumericValue($product, ['unit_price', 'price', 'sell_price', 'sale_price']);
        $stock = max(0, (int) $this->firstNumericValue($product, ['stock', 'available_stock', 'quantity', 'inventory']));

        return view('2khanonline.products.show', [
            'product' => $product,
            'imageUrl' => $this->productImageUrl($product),
            'categoryName' => $this->displayName($product, 'category'),
            'brandName' => $this->displayName($product, 'brand'),
            'unitPrice' => $unitPrice,
            'stock' => $stock,
        ]);
    }

    public function category(ProductCategory $category, Request $request): View
    {
        $brandId = $request->integer('brand');
        $sort = $request->string('sort')->toString();

        $productsQuery = $category->products()->with('brand');

        if ($brandId > 0) {
            $productsQuery->where('product_brand_id', $brandId);
        }

        match ($sort) {
            'price_asc' => $productsQuery->orderBy('price')->orderByDesc('id'),
            'price_desc' => $productsQuery->orderByDesc('price')->orderByDesc('id'),
            default => $productsQuery->orderByDesc('id'),
        };

        $products = $productsQuery
            ->paginate(12);
        $products->withQueryString();

        $brands = ProductBrand::query()
            ->whereHas('products', fn ($query) => $query->where('product_category_id', $category->id))
            ->orderBy('name')
            ->get();

        return view('2khanonline.products.category', compact('category', 'products', 'brands', 'brandId', 'sort'));
    }

    private function productImageUrl(object $product): ?string
    {
        foreach (['img_url', 'image_url', 'image', 'thumbnail_url'] as $attribute) {
            if (filled($product->{$attribute} ?? null)) {
                return (string) $product->{$attribute};
            }
        }

        if (! method_exists($product, 'getFirstMediaUrl')) {
            return null;
        }

        foreach (['img', 'image', 'images', 'product_image', 'product-images', 'products'] as $collection) {
            $url = $product->getFirstMediaUrl($collection);

            if ($url !== '') {
                return $url;
            }
        }

        $url = $product->getFirstMediaUrl();

        return $url !== '' ? $url : null;
    }

    private function displayName(object $model, string $name): ?string
    {
        foreach (["{$name}_name", "{$name}_title"] as $attribute) {
            if (filled($model->{$attribute} ?? null)) {
                return (string) $model->{$attribute};
            }
        }

        if (! isset($model->{$name})) {
            return null;
        }

        $value = $model->{$name};

        if (is_string($value) && filled($value)) {
            return $value;
        }

        if (! is_object($value)) {
            return null;
        }

        foreach (['name', 'title', 'label'] as $attribute) {
            if (filled($value->{$attribute} ?? null)) {
                return (string) $value->{$attribute};
            }
        }

        return null;
    }

    private function firstNumericValue(object $model, array $attributes): int|float
    {
        foreach ($attributes as $attribute) {
            if (isset($model->{$attribute}) && is_numeric($model->{$attribute})) {
                return $model->{$attribute} + 0;
            }
        }

        return 0;
    }
}

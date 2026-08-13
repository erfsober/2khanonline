<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        $brands = ProductBrand::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'product_brand_id' => 'required|exists:product_brands,id',
            'name' => 'required|string|max:255|unique:products,name',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
        ], [
            'product_category_id.required' => 'انتخاب دسته‌بندی الزامی است',
            'product_category_id.exists' => 'دسته‌بندی انتخاب شده معتبر نیست',
            'product_brand_id.required' => 'انتخاب برند الزامی است',
            'product_brand_id.exists' => 'برند انتخاب شده معتبر نیست',
            'name.required' => 'نام محصول الزامی است',
            'name.unique' => 'این نام محصول قبلاً ثبت شده است',
            'slug.required' => 'اسلاگ الزامی است',
            'slug.unique' => 'این اسلاگ قبلاً ثبت شده است',
            'price.required' => 'قیمت الزامی است',
            'price.integer' => 'قیمت باید عدد باشد',
            'price.min' => 'قیمت نمی‌تواند منفی باشد',
            'stock.required' => 'موجودی الزامی است',
            'stock.integer' => 'موجودی باید عدد باشد',
            'stock.min' => 'موجودی نمی‌تواند منفی باشد',
            'discount.integer' => 'درصد تخفیف باید عدد باشد',
            'discount.min' => 'درصد تخفیف نمی‌تواند منفی باشد',
            'discount.max' => 'درصد تخفیف نمی‌تواند بیشتر از ۱۰۰ باشد',
            'image.image' => 'فایل ارسالی باید تصویر باشد',
            'image.mimes' => 'تصویر ارسالی باید از فرمت های jpg، jpeg، png، gif یا webp باشد',
        ]);

        $product = Product::create([
            'product_category_id' => $request->product_category_id,
            'product_brand_id' => $request->product_brand_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->filled('discount') ? $request->discount : null,
        ]);

        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'محصول با موفقیت ایجاد شد!');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::orderBy('name')->get();
        $brands = ProductBrand::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'product_brand_id' => 'required|exists:product_brands,id',
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'remove_image' => 'nullable|boolean',
        ], [
            'product_category_id.required' => 'انتخاب دسته‌بندی الزامی است',
            'product_category_id.exists' => 'دسته‌بندی انتخاب شده معتبر نیست',
            'product_brand_id.required' => 'انتخاب برند الزامی است',
            'product_brand_id.exists' => 'برند انتخاب شده معتبر نیست',
            'name.required' => 'نام محصول الزامی است',
            'name.unique' => 'این نام محصول قبلاً ثبت شده است',
            'slug.required' => 'اسلاگ الزامی است',
            'slug.unique' => 'این اسلاگ قبلاً ثبت شده است',
            'price.required' => 'قیمت الزامی است',
            'price.integer' => 'قیمت باید عدد باشد',
            'price.min' => 'قیمت نمی‌تواند منفی باشد',
            'stock.required' => 'موجودی الزامی است',
            'stock.integer' => 'موجودی باید عدد باشد',
            'stock.min' => 'موجودی نمی‌تواند منفی باشد',
            'discount.integer' => 'درصد تخفیف باید عدد باشد',
            'discount.min' => 'درصد تخفیف نمی‌تواند منفی باشد',
            'discount.max' => 'درصد تخفیف نمی‌تواند بیشتر از ۱۰۰ باشد',
            'image.image' => 'فایل ارسالی باید تصویر باشد',
            'image.mimes' => 'تصویر ارسالی باید از فرمت های jpg، jpeg، png، gif یا webp باشد',
        ]);

        $product->update([
            'product_category_id' => $request->product_category_id,
            'product_brand_id' => $request->product_brand_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->filled('discount') ? $request->discount : null,
        ]);

        if ($request->boolean('remove_image')) {
            $product->clearMediaCollection('image');
        }

        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'محصول با موفقیت بروزرسانی شد!');
    }

    public function destroy(Product $product)
    {
        $product->clearMediaCollection('image');
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'محصول با موفقیت حذف شد!');
    }
}

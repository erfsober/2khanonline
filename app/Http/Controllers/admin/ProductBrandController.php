<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductBrandController extends Controller
{
    public function index()
    {
        $brands = ProductBrand::latest()->get();

        return view('admin.product-brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.product-brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_brands,name',
            'slug' => 'required|string|max:255|unique:product_brands,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
        ], [
            'name.required' => 'نام برند الزامی است',
            'name.unique' => 'این نام برند قبلاً ثبت شده است',
            'slug.required' => 'اسلاگ الزامی است',
            'slug.unique' => 'این اسلاگ قبلاً ثبت شده است',
            'image.image' => 'فایل ارسالی باید تصویر باشد',
            'image.mimes' => 'تصویر ارسالی باید از فرمت های jpg، jpeg، png، gif یا webp باشد',
        ]);

        $brand = ProductBrand::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);

        if ($request->hasFile('image')) {
            $brand->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.product-brands.index')
            ->with('success', 'برند با موفقیت ایجاد شد!');
    }

    public function edit(ProductBrand $productBrand)
    {
        return view('admin.product-brands.edit', compact('productBrand'));
    }

    public function update(Request $request, ProductBrand $productBrand)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_brands,name,' . $productBrand->id,
            'slug' => 'required|string|max:255|unique:product_brands,slug,' . $productBrand->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'remove_image' => 'nullable|boolean',
        ], [
            'name.required' => 'نام برند الزامی است',
            'name.unique' => 'این نام برند قبلاً ثبت شده است',
            'slug.required' => 'اسلاگ الزامی است',
            'slug.unique' => 'این اسلاگ قبلاً ثبت شده است',
            'image.image' => 'فایل ارسالی باید تصویر باشد',
            'image.mimes' => 'تصویر ارسالی باید از فرمت های jpg، jpeg، png، gif یا webp باشد',
        ]);

        $productBrand->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
        ]);

        if ($request->boolean('remove_image')) {
            $productBrand->clearMediaCollection('image');
        }

        if ($request->hasFile('image')) {
            $productBrand->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.product-brands.index')
            ->with('success', 'برند با موفقیت بروزرسانی شد!');
    }

    public function destroy(ProductBrand $productBrand)
    {
        $productBrand->clearMediaCollection('image');
        $productBrand->delete();

        return redirect()->route('admin.product-brands.index')
            ->with('success', 'برند با موفقیت حذف شد!');
    }
}

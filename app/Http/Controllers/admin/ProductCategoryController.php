<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::latest()->get();

        return view('admin.product-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.product-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name',
            'slug' => 'required|string|max:255|unique:product_categories,slug',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
        ], [
            'name.required' => 'نام دسته‌بندی الزامی است',
            'name.unique' => 'این نام دسته‌بندی قبلاً ثبت شده است',
            'slug.required' => 'اسلاگ الزامی است',
            'slug.unique' => 'این اسلاگ قبلاً ثبت شده است',
            'image.image' => 'فایل ارسالی باید تصویر باشد',
            'image.mimes' => 'تصویر ارسالی باید از فرمت های jpg، jpeg، png، gif یا webp باشد',
        ]);

        $category = ProductCategory::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        if ($request->hasFile('image')) {
            $category->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'دسته‌بندی با موفقیت ایجاد شد!');
    }

    public function edit(ProductCategory $productCategory)
    {
        return view('admin.product-categories.edit', compact('productCategory'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name,' . $productCategory->id,
            'slug' => 'required|string|max:255|unique:product_categories,slug,' . $productCategory->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'remove_image' => 'nullable|boolean',
        ], [
            'name.required' => 'نام دسته‌بندی الزامی است',
            'name.unique' => 'این نام دسته‌بندی قبلاً ثبت شده است',
            'slug.required' => 'اسلاگ الزامی است',
            'slug.unique' => 'این اسلاگ قبلاً ثبت شده است',
            'image.image' => 'فایل ارسالی باید تصویر باشد',
            'image.mimes' => 'تصویر ارسالی باید از فرمت های jpg، jpeg، png، gif یا webp باشد',
        ]);

        $productCategory->update([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        if ($request->boolean('remove_image')) {
            $productCategory->clearMediaCollection('image');
        }

        if ($request->hasFile('image')) {
            $productCategory->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'دسته‌بندی با موفقیت بروزرسانی شد!');
    }

    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->clearMediaCollection('image');
        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'دسته‌بندی با موفقیت حذف شد!');
    }
}

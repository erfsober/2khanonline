<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function edit()
    {
        $aboutUs = AboutUs::first();

        if (!$aboutUs) {
            $aboutUs = AboutUs::create([
                'title' => 'درباره ما',
                'description' => '',
            ]);
        }

        return view('admin.settings.about-us.edit', compact('aboutUs'));
    }

    public function update(Request $request)
    {
        $aboutUs = AboutUs::first();

        if (!$aboutUs) {
            $aboutUs = AboutUs::create([
                'title' => 'درباره ما',
                'description' => '',
            ]);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'remove_img' => 'nullable|boolean',
        ], [
            'title.required' => 'عنوان الزامی است',
            'title.max' => 'حداکثر کاراکتر عنوان 255 است',
            'description.required' => 'توضیحات الزامی است',
            'img.image' => 'فایل ارسالی باید تصویر باشد',
            'img.mimes' => 'تصویر ارسالی باید از فرمت های jpg، jpeg، png، gif یا webp باشد',
        ]);

        $aboutUs->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->boolean('remove_img')) {
            $aboutUs->clearMediaCollection('img');
        }

        if ($request->hasFile('img')) {
            $aboutUs->addMediaFromRequest('img')->toMediaCollection('img');
        }

        return redirect()->route('admin.about-us.edit')
            ->with('success', 'اطلاعات درباره ما با موفقیت بروزرسانی شد!');
    }
}

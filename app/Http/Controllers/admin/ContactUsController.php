<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function edit()
    {
        $contactUs = ContactUs::first();

        if (!$contactUs) {
            $contactUs = ContactUs::create([
                'title' => 'تماس با ما',
                'description' => '',
            ]);
        }

        return view('admin.settings.contact-us.edit', compact('contactUs'));
    }

    public function update(Request $request)
    {
        $contactUs = ContactUs::first();

        if (!$contactUs) {
            $contactUs = ContactUs::create([
                'title' => 'تماس با ما',
                'description' => '',
            ]);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string',
            'telegram' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ], [
            'title.required' => 'عنوان الزامی است',
            'title.max' => 'حداکثر کاراکتر عنوان 255 است',
            'description.required' => 'توضیحات الزامی است',
        ]);

        $contactUs->update($request->only([
            'title',
            'description',
            'location',
            'telegram',
            'whatsapp',
            'address',
        ]));

        return redirect()->route('admin.contact-us.edit')
            ->with('success', 'اطلاعات تماس با ما با موفقیت بروزرسانی شد!');
    }
}

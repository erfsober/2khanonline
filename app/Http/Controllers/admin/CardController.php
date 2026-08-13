<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function edit()
    {
        $card = Card::first();

        return view('admin.financial.card.edit', compact('card'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string|min:16|max:19',
            'card_holder_name' => 'required|string|min:2|max:255',
        ], [
            'card_number.required' => 'شماره کارت الزامی است',
            'card_number.string' => 'شماره کارت باید متن باشد',
            'card_number.min' => 'شماره کارت باید حداقل ۱۶ رقم باشد',
            'card_number.max' => 'شماره کارت حداکثر ۱۹ رقم می‌تواند باشد',
            'card_holder_name.required' => 'نام و نام خانوادگی صاحب کارت الزامی است',
            'card_holder_name.string' => 'نام صاحب کارت باید متن باشد',
            'card_holder_name.min' => 'نام صاحب کارت باید حداقل ۲ کاراکتر باشد',
            'card_holder_name.max' => 'نام صاحب کارت حداکثر ۲۵۵ کاراکتر می‌تواند باشد',
        ]);

        $card = Card::first();

        if ($card) {
            $card->update($request->only('card_number', 'card_holder_name'));
        } else {
            Card::create($request->only('card_number', 'card_holder_name'));
        }

        return redirect()->route('admin.financial.card.edit')
            ->with('success', 'اطلاعات کارت بانکی با موفقیت ذخیره شد!');
    }
}

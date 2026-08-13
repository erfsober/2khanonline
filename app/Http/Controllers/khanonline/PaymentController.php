<?php

namespace App\Http\Controllers\khanonline;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    public function show(Order $order): View|RedirectResponse
    {
        if ($order->status !== Order::STATUS_PENDING) {
            return redirect()->route('orders.index');
        }

        if (auth()->id() !== $order->user_id) {
            abort(403);
        }

        $card = Card::first();

        return view('2khanonline.payment.card-to-card', [
            'order' => $order,
            'card' => $card,
        ]);
    }

    public function uploadReceipt(Request $request, Order $order): RedirectResponse
    {
        if ($order->status !== Order::STATUS_PENDING) {
            return redirect()->route('orders.index');
        }

        if (auth()->id() !== $order->user_id) {
            abort(403);
        }

        $request->validate([
            'receipt' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'receipt.required' => 'لطفاً تصویر فیش پرداخت را آپلود کنید.',
            'receipt.image' => 'فایل ارسالی باید تصویر باشد.',
            'receipt.mimes' => 'فرمت تصویر باید jpg، jpeg، png یا webp باشد.',
            'receipt.max' => 'حجم تصویر نباید بیشتر از ۵ مگابایت باشد.',
        ]);

        $order->clearMediaCollection('receipt');
        $order->addMediaFromRequest('receipt')->toMediaCollection('receipt');

        $order->update([
            'payment_status' => Order::PAYMENT_PENDING,
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'فیش پرداخت با موفقیت ارسال شد. پس از بررسی توسط مدیر، وضعیت سفارش شما بروزرسانی خواهد شد.');
    }

    public function callback(): RedirectResponse
    {
        return redirect()->route('cart.index');
    }
}

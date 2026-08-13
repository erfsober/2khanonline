<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('phone', 'like', "%{$search}%");
                })->orWhereHas('items', function ($q2) use ($search) {
                    $q2->where('product_name', 'like', "%{$search}%");
                });
            });
        }

        if ($status = $request->input('payment_status')) {
            $query->where('payment_status', $status);
        }

        switch ($request->input('sort')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'shipping_status':
                $query->orderBy('shipping_status')->latest();
                break;
            default:
                $query->latest();
                break;
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items']);

        return view('admin.orders.show', compact('order'));
    }

    public function approve(Order $order)
    {
        DB::transaction(function () use ($order): void {
            $order->update([
                'payment_status' => Order::PAYMENT_APPROVED,
                'status' => Order::STATUS_PAID,
                'paid_at' => now(),
            ]);

            foreach ($order->items as $item) {
                if (! $item->product_id) {
                    continue;
                }

                \App\Models\Product::query()
                    ->whereKey($item->product_id)
                    ->where('stock', '>=', $item->quantity)
                    ->decrement('stock', $item->quantity);
            }

            $cartService = app(CartService::class);
            $cartService->clear();
        });

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'فیش پرداخت تأیید شد و سفارش پرداخت‌شده اعلام گردید.');
    }

    public function reject(Order $order)
    {
        $order->update([
            'payment_status' => Order::PAYMENT_REJECTED,
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'فیش پرداخت رد شد.');
    }

    public function updateShippingStatus(Request $request, Order $order)
    {
        $request->validate([
            'shipping_status' => 'required|in:packing,sent',
        ], [
            'shipping_status.required' => 'وضعیت ارسال الزامی است',
            'shipping_status.in' => 'وضعیت ارسال معتبر نیست',
        ]);

        $order->shipping_status = $request->shipping_status;
        $order->save();

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'وضعیت ارسال سفارش با موفقیت بروزرسانی شد!');
    }
}

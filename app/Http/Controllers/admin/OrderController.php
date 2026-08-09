<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items'])->where('status', 'paid');

        // Search by phone or product name
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('phone', 'like', "%{$search}%");
                })->orWhereHas('items', function ($q2) use ($search) {
                    $q2->where('product_name', 'like', "%{$search}%");
                });
            });
        }

        // Sorting
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

        return redirect()->route('admin.orders.index')
            ->with('success', 'وضعیت ارسال سفارش با موفقیت بروزرسانی شد!');
    }
}

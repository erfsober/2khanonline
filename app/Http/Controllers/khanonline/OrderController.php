<?php

namespace App\Http\Controllers\khanonline;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()
            ->orders()
            ->with('items')
            ->latest()
            ->get();

        return view('2khanonline.orders.index', [
            'orders' => $orders,
        ]);
    }
}

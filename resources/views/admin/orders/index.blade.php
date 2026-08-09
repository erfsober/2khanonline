@extends('admin.layouts.app')

@section('title', 'سفارشات')

@section('content')

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت سفارشات /</span> سفارشات
    </h4>

    <div class="card">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center m-3">
            <h5 class="mb-0">لیست سفارشات</h5>
        </div>

        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 mx-3 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="جستجو با شماره تلفن یا نام محصول"
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>جدیدترین</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>قدیمی‌ترین</option>
                    <option value="shipping_status" {{ request('sort') === 'shipping_status' ? 'selected' : '' }}>وضعیت ارسال</option>
                </select>
            </div>
            <div class="col-md-5">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bx bx-search me-1"></i> جستجو
                </button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-reset me-1"></i> بازنشانی
                </a>
            </div>
        </form>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>شناسه سفارش</th>
                    <th>شماره مشتری</th>
                    <th>مبلغ کل</th>
                    <th>وضعیت سفارش</th>
                    <th>وضعیت ارسال</th>
                    <th>تاریخ سفارش</th>
                    <th>محصولات</th>
                    <th>عملیات</th>
                </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                @forelse ($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->user->phone ?? '—' }}</td>
                        <td>{{ number_format($order->amount) }} تومان</td>
                        <td>
                            @if($order->status === 'paid')
                                <span class="badge bg-label-success">پرداخت شده</span>
                            @elseif($order->status === 'pending')
                                <span class="badge bg-label-warning">در انتظار پرداخت</span>
                            @else
                                <span class="badge bg-label-danger">ناموفق</span>
                            @endif
                        </td>
                        <td>
                            @if($order->shipping_status === 'sent')
                                <span class="badge bg-label-success">ارسال شده</span>
                            @else
                                <span class="badge bg-label-info">در حال بسته‌بندی</span>
                            @endif
                        </td>
                        <td>{{ verta(optional($order->created_at)->format('Y/m/d')) }}</td>
                        <td>
                            @foreach($order->items as $item)
                                <span class="badge bg-label-primary">{{ $item->product_name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <form action="{{ route('admin.orders.update-shipping-status', $order) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="shipping_status" value="{{ $order->shipping_status === 'packing' ? 'sent' : 'packing' }}">
                                @if($order->shipping_status === 'packing')
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bx bx-package me-1"></i> تغییر به ارسال شده
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-warning">
                                        <i class="bx bx-revision me-1"></i> تغییر به بسته‌بندی
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">سفارشی یافت نشد.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="card-footer">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

@endsection

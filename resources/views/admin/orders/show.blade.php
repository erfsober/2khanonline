@extends('admin.layouts.app')

@section('title', 'مشاهده سفارش')

@section('content')

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت سفارشات /</span>
        <a href="{{ route('admin.orders.index') }}" class="text-muted fw-light">سفارشات</a>
        <span class="text-muted fw-light">/</span> سفارش #{{ $order->id }}
    </h4>

    {{-- Order Info --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">اطلاعات سفارش</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">شناسه سفارش</span>
                    <strong>#{{ $order->id }}</strong>
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">شماره مشتری</span>
                    <strong>{{ $order->user->phone ?? '—' }}</strong>
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">مبلغ کل</span>
                    <strong>{{ number_format($order->amount) }} تومان</strong>
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">وضعیت سفارش</span>
                    @if($order->status === 'paid')
                        <span class="badge bg-label-success">پرداخت شده</span>
                    @elseif($order->status === 'pending')
                        <span class="badge bg-label-warning">در انتظار پرداخت</span>
                    @else
                        <span class="badge bg-label-danger">ناموفق</span>
                    @endif
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">وضعیت ارسال</span>
                    @if($order->shipping_status === 'sent')
                        <span class="badge bg-label-success">ارسال شده</span>
                    @else
                        <span class="badge bg-label-info">در حال بسته‌بندی</span>
                    @endif
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">درگاه پرداخت</span>
                    <strong>{{ $order->gateway }}</strong>
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">کد پیگیری</span>
                    <strong>{{ $order->transaction_id ?? '—' }}</strong>
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">مرجع</span>
                    <strong>{{ $order->reference_id ?? '—' }}</strong>
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">تاریخ سفارش</span>
                    <strong>{{ verta($order->created_at)->format('Y/m/d H:i') }}</strong>
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">تاریخ پرداخت</span>
                    <strong>{{ $order->paid_at ? verta($order->paid_at)->format('Y/m/d H:i') : '—' }}</strong>
                </div>
                <div class="col-md-8 mb-3">
                    <span class="text-muted d-block mb-1">آدرس ارسال</span>
                    <strong>{{ $order->address ?? '—' }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Items --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">محصولات سفارش</h5>
        </div>

        @if($order->items->isEmpty())
            <div class="card-body text-center text-muted py-5">
                محصولی برای این سفارش ثبت نشده است.
            </div>
        @else
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>نام محصول</th>
                        <th>قیمت واحد</th>
                        <th>تعداد</th>
                        <th>قیمت کل</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach ($order->items as $item)
                        <tr>
                            <td><strong>#{{ $item->id }}</strong></td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ number_format($item->price) }} تومان</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price * $item->quantity) }} تومان</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection

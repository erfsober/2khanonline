@extends('admin.layouts.app')

@section('title', 'مشاهده سفارش')

@section('content')

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت سفارشات /</span>
        <a href="{{ route('admin.orders.index') }}" class="text-muted fw-light">سفارشات</a>
        <span class="text-muted fw-light">/</span> سفارش #{{ $order->id }}
    </h4>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                    <span class="text-muted d-block mb-1">وضعیت فیش پرداخت</span>
                    @if($order->payment_status === 'approved')
                        <span class="badge bg-label-success">تأیید شده</span>
                    @elseif($order->payment_status === 'rejected')
                        <span class="badge bg-label-danger">رد شده</span>
                    @else
                        <span class="badge bg-label-warning">در انتظار بررسی</span>
                    @endif
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">روش پرداخت</span>
                    <strong>{{ $order->gateway === 'card_to_card' ? 'کارت‌به‌کارت' : $order->gateway }}</strong>
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

    {{-- Receipt --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">فیش پرداخت</h5>
            @if($order->receipt_url)
                                @if($order->payment_status !== 'approved')
                                    <form action="{{ route('admin.orders.approve', $order) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('آیا از تأیید فیش پرداخت این سفارش اطمینان دارید؟')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success me-1">
                                            <i class="bx bx-check me-1"></i> تأیید فیش
                                        </button>
                                    </form>
                                @endif

                                @if($order->payment_status !== 'rejected')
                                    <form action="{{ route('admin.orders.reject', $order) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('آیا از رد فیش پرداخت این سفارش اطمینان دارید؟')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bx bx-x me-1"></i> رد فیش
                                        </button>
                                    </form>
                                @endif
                            @endif
        </div>
        <div class="card-body">
            @if($order->receipt_url)
                <div class="text-center">
                    <a href="{{ $order->receipt_url }}" target="_blank">
                        <img src="{{ $order->receipt_url }}" alt="فیش پرداخت"
                             class="img-fluid rounded-3 shadow-sm border" style="max-height: 400px;">
                    </a>
                    <p class="text-muted mt-2"><small>برای مشاهده اندازه کامل روی تصویر کلیک کنید</small></p>
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="bx bx-image bx-lg d-block mb-2"></i>
                    فیش پرداخت آپلود نشده است.
                </div>
            @endif
        </div>
    </div>

    {{-- Shipping Status --}}
    @if($order->payment_status === 'approved')
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-4">وضعیت ارسال</h5>
                <form action="{{ route('admin.orders.update-shipping-status', $order) }}" method="POST" class="row align-items-end">
                    @csrf
                    @method('PATCH')
                    <div class="col-md-6">
                        <label for="shipping_status" class="form-label">تغییر وضعیت ارسال</label>
                        <select name="shipping_status" id="shipping_status" class="form-select">
                            <option value="packing" {{ $order->shipping_status === 'packing' ? 'selected' : '' }}>در حال بسته‌بندی</option>
                            <option value="sent" {{ $order->shipping_status === 'sent' ? 'selected' : '' }}>ارسال شده</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i> بروزرسانی وضعیت ارسال
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

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

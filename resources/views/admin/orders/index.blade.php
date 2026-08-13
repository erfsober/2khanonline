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
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="جستجو با شماره تلفن یا نام محصول"
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="payment_status" class="form-select">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>در انتظار بررسی</option>
                    <option value="approved" {{ request('payment_status') === 'approved' ? 'selected' : '' }}>تأیید شده</option>
                    <option value="rejected" {{ request('payment_status') === 'rejected' ? 'selected' : '' }}>رد شده</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="sort" class="form-select">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>جدیدترین</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>قدیمی‌ترین</option>
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
                    <th>شناسه</th>
                    <th>شماره مشتری</th>
                    <th>مبلغ کل</th>
                    <th>وضعیت پرداخت</th>
                    <th>فیش</th>
                    <th>تاریخ</th>
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
                            @if($order->payment_status === 'approved')
                                <span class="badge bg-label-success">تأیید شده</span>
                            @elseif($order->payment_status === 'rejected')
                                <span class="badge bg-label-danger">رد شده</span>
                            @elseif($order->receipt_url)
                                <span class="badge bg-label-warning">در انتظار بررسی</span>
                            @else
                                <span class="badge bg-label-secondary">بدون فیش</span>
                            @endif
                        </td>
                        <td>
                            @if($order->receipt_url)
                                <a href="{{ $order->receipt_url }}" target="_blank" title="مشاهده فیش">
                                    <img src="{{ $order->receipt_thumb_url ?? $order->receipt_url }}" alt="فیش" class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ verta(optional($order->created_at)->format('Y/m/d')) }}</td>
                        <td>
                            @foreach($order->items as $item)
                                <span class="badge bg-label-primary">{{ $item->product_name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bx bx-show me-1"></i> مشاهده
                            </a>

                            @if($order->receipt_url)
                                @if($order->payment_status !== 'approved')
                                    <form action="{{ route('admin.orders.approve', $order) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('آیا از تأیید فیش پرداخت این سفارش اطمینان دارید؟')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success me-1">
                                            <i class="bx bx-check me-1"></i> تأیید
                                        </button>
                                    </form>
                                @endif

                                @if($order->payment_status !== 'rejected')
                                    <form action="{{ route('admin.orders.reject', $order) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('آیا از رد فیش پرداخت این سفارش اطمینان دارید؟')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bx bx-x me-1"></i> رد
                                        </button>
                                    </form>
                                @endif
                            @endif
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

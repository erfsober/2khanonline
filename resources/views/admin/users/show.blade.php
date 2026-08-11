@extends('admin.layouts.app')

@section('title', 'مشاهده کاربر')

@section('content')

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت کاربران /</span>
        <a href="{{ route('admin.users.index') }}" class="text-muted fw-light">کاربران</a>
        <span class="text-muted fw-light">/</span> کاربر #{{ $user->id }}
    </h4>

    {{-- User Info --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">اطلاعات کاربر</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">شناسه</span>
                    <strong>{{ $user->id }}</strong>
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">شماره تلفن</span>
                    <strong>{{ $user->phone }}</strong>
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">وضعیت تایید شماره</span>
                    @if($user->phone_verified_at)
                        <span class="badge bg-label-success">تایید شده</span>
                    @else
                        <span class="badge bg-label-danger">تایید نشده</span>
                    @endif
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">تاریخ عضویت</span>
                    <strong>{{ verta($user->created_at)->format('Y/m/d H:i') }}</strong>
                </div>
                <div class="col-md-4 mb-3">
                    <span class="text-muted d-block mb-1">تعداد سفارشات</span>
                    <span class="badge bg-label-primary">{{ $user->orders->count() }}</span>
                </div>
                <div class="col-md-8 mb-3">
                    <span class="text-muted d-block mb-1">آدرس</span>
                    <strong>{{ $user->address ?? '—' }}</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Orders --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">سفارشات کاربر</h5>
        </div>

        @if($user->orders->isEmpty())
            <div class="card-body text-center text-muted py-5">
                این کاربر هنوز سفارشی ثبت نکرده است.
            </div>
        @else
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th>شناسه سفارش</th>
                        <th>مبلغ کل</th>
                        <th>وضعیت سفارش</th>
                        <th>وضعیت ارسال</th>
                        <th>محصولات</th>
                        <th>تاریخ</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach ($user->orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
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
                            <td>
                                @foreach($order->items as $item)
                                    <span class="badge bg-label-primary">{{ $item->product_name }}</span>
                                @endforeach
                            </td>
                            <td>{{ verta(optional($order->created_at)->format('Y/m/d')) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection

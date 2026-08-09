@extends('2khanonline.layout.main')

@section('title', 'سفارش‌های من | دو خان')

@section('content')
    <section class="pt-6 lg:pt-8 pb-16 lg:pb-20">
        <div class="max-w-[1260px] mx-auto px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-[#737373] mb-6" aria-label="breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-[#171717] transition-colors">خانه</a>
                <span class="text-[#D4D4D4]">/</span>
                <span class="text-[#171717] font-medium">سفارش‌های من</span>
            </nav>

            <div class="mb-8">
                <span class="inline-flex text-xs font-medium text-[#B88A2A] bg-[#B88A2A]/10 px-3 py-1 rounded-full mb-3">حساب کاربری</span>
                <h1 class="text-2xl lg:text-[36px] font-bold leading-tight text-[#171717]">سفارش‌های من</h1>
                <p class="text-sm text-[#737373] mt-3">تاریخچه سفارش‌ها و وضعیت پرداخت آن‌ها را اینجا ببینید.</p>
            </div>

            @if ($orders->isEmpty())
                <div class="bg-white border border-[#E5E5E5] rounded-[24px] p-10 lg:p-14 text-center shadow-[0_24px_70px_rgba(23,23,23,0.05)]">
                    <div class="w-16 h-16 mx-auto rounded-3xl bg-[#FAFAF9] border border-[#E5E5E5] flex items-center justify-center text-[#B88A2A] mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold mb-2">هنوز سفارشی ثبت نکرده‌اید</h2>
                    <p class="text-sm text-[#737373] mb-6">پس از تکمیل خرید، سفارش‌های شما اینجا نمایش داده می‌شوند.</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-2xl bg-[#171717] px-6 py-3 text-sm font-semibold text-white hover:bg-[#2a2a2a] transition-colors">
                        بازگشت به فروشگاه
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        @php
                            $statusLabel = match ($order->status) {
                                'paid' => 'پرداخت شده',
                                'failed' => 'ناموفق',
                                default => 'در انتظار پرداخت',
                            };
                            $statusClasses = match ($order->status) {
                                'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                'failed' => 'bg-red-50 text-red-600 border-red-100',
                                default => 'bg-amber-50 text-amber-700 border-amber-100',
                            };
                        @endphp

                        <article class="bg-white border border-[#E5E5E5] rounded-[24px] p-5 lg:p-6 shadow-[0_24px_70px_rgba(23,23,23,0.05)]">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5 pb-5 border-b border-[#F5F5F5]">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h2 class="text-base font-bold text-[#171717]">سفارش #{{ $order->id }}</h2>
                                    <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                                <div class="text-xs text-[#737373]">
                                    {{ verta($order->created_at)->format('Y/m/d H:i') }}
                                </div>
                            </div>

                            <ul class="space-y-3 mb-5">
                                @foreach ($order->items as $item)
                                    <li class="flex items-center justify-between gap-4 text-sm">
                                        <div class="min-w-0">
                                            <span class="font-medium text-[#171717]">{{ $item->product_name }}</span>
                                            <span class="text-[#737373]"> × {{ number_format($item->quantity) }}</span>
                                        </div>
                                        <strong class="shrink-0 text-[#171717]">{{ number_format($item->subtotal()) }} تومان</strong>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="rounded-2xl bg-[#FAFAF9] border border-[#E5E5E5] p-4 space-y-2 text-sm">
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-[#737373]">مبلغ کل</span>
                                    <strong class="text-base text-[#171717]">{{ number_format($order->amount) }} تومان</strong>
                                </div>
                                @if ($order->reference_id)
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-[#737373]">کد پیگیری</span>
                                        <strong dir="ltr">{{ $order->reference_id }}</strong>
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection

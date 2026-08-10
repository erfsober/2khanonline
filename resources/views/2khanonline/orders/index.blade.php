@extends('2khanonline.layout.main')

@section('title', 'سفارش‌های من | Smokify | اسموکیفای')
@section('seo_robots', 'noindex,nofollow,noarchive')

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

                            @if($order->status === 'paid')
                                {{-- Shipping Status --}}
                                <div class="mb-5 p-4 rounded-2xl border border-[#E5E5E5] bg-[#FAFAF9]">
                                    <div class="flex items-center gap-2 mb-3">
                                        @if($order->shipping_status === 'sent')
                                            <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-emerald-50 border border-emerald-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                                </svg>
                                            </span>
                                        @else
                                            <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-amber-50 border border-amber-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25-2.25M12 13.875V7.5" />
                                                </svg>
                                            </span>
                                        @endif
                                        <span class="text-xs font-medium text-[#737373]">وضعیت ارسال</span>
                                    </div>
                                    <div class="w-full h-2 rounded-full bg-[#E5E5E5] overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500 {{ $order->shipping_status === 'sent' ? 'w-full bg-emerald-500' : 'w-1/2 bg-amber-400' }}"></div>
                                    </div>
                                    <div class="flex items-center justify-between mt-2.5">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full {{ $order->shipping_status === 'packing' ? 'bg-amber-400 animate-pulse' : 'bg-emerald-500' }}"></span>
                                            <span class="text-xs font-medium {{ $order->shipping_status === 'packing' ? 'text-amber-600' : 'text-[#A3A3A3]' }}">بسته‌بندی</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full {{ $order->shipping_status === 'sent' ? 'bg-emerald-500' : 'bg-[#D4D4D4]' }}"></span>
                                            <span class="text-xs font-medium {{ $order->shipping_status === 'sent' ? 'text-emerald-600' : 'text-[#A3A3A3]' }}">ارسال شده</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

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

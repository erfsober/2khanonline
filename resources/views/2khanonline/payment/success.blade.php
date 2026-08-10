@extends('2khanonline.layout.main')

@section('title', 'پرداخت موفق | Smokify | اسموکیفای')
@section('seo_robots', 'noindex,nofollow,noarchive')

@section('content')
    <section class="pt-6 lg:pt-8 pb-16 lg:pb-20">
        <div class="max-w-[720px] mx-auto px-6 lg:px-8">
            <div class="bg-white border border-[#E5E5E5] rounded-[24px] p-8 lg:p-12 text-center shadow-[0_24px_70px_rgba(23,23,23,0.05)]">
                <div class="w-20 h-20 mx-auto rounded-3xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>

                <h1 class="text-2xl font-bold mb-2">پرداخت با موفقیت انجام شد</h1>
                <p class="text-sm text-[#737373] leading-7 mb-8">سفارش شما ثبت شد و پرداخت آن تأیید گردید.</p>

                <div class="rounded-2xl bg-[#FAFAF9] border border-[#E5E5E5] p-5 text-sm text-right space-y-3 mb-8">
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-[#737373]">شماره سفارش</span>
                        <strong>{{ $order->id }}</strong>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-[#737373]">مبلغ پرداختی</span>
                        <strong>{{ number_format($order->amount) }} تومان</strong>
                    </div>
                    @if ($order->reference_id)
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-[#737373]">کد پیگیری</span>
                            <strong dir="ltr">{{ $order->reference_id }}</strong>
                        </div>
                    @endif
                </div>

                <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-2xl bg-[#171717] px-6 py-3 text-sm font-semibold text-white hover:bg-[#2a2a2a] transition-colors">
                    بازگشت به فروشگاه
                </a>
            </div>
        </div>
    </section>
@endsection

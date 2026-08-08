@extends('2khanonline.layout.main')

@section('title', 'دو خان | فروشگاه آنلاین')

@section('content')

    {{-- ==================== HERO ==================== --}}
    <section class="pt-8 pb-12">
        <div class="max-w-[1260px] mx-auto px-6 lg:px-8">
            <div class="relative rounded-[20px] overflow-hidden h-[280px] lg:h-[340px]">
                {{-- Background Image --}}
                <img
                    src="{{asset('images/main.png')}}"
                    alt="محصولات تنباکو"
                    class="absolute inset-0 w-full h-full object-cover"
                >

                {{-- Content --}}
                <div class="relative z-10 flex items-center h-full px-8 lg:px-16">
                    <div class="text-right max-w-lg">
                        <span class="inline-block text-xs font-medium text-orange-400 bg-[#B88A2A]/10 px-3 py-1 rounded-full mb-5">کیفیت بی‌نظیر</span>
                        <h1 class="text-2xl lg:text-[38px] font-bold leading-tight mb-3 text-[#171717]">بهترین محصولات دخانیات</h1>
                        <p class="text-[#737373] text-sm leading-6 mb-6">مجموعه‌ای از محصولات باکیفیت و معتبر، با طراحی ساده و انتخابی مطمئن.</p>
                        <a href="#" class="inline-flex items-center gap-2 bg-[#171717] text-white px-7 py-3 rounded-lg text-sm font-medium hover:bg-[#2a2a2a] transition-colors">
                            مشاهده محصولات
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== CATEGORIES ==================== --}}
    <section class="max-w-[1260px] mx-auto px-6 lg:px-8 pb-16">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($categories as $category)
                <a href="#" class="bg-white border border-[#E5E5E5] rounded-2xl p-5 flex items-center gap-4 hover:border-[#d4d4d4] transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-[#FAFAF9] flex items-center justify-center text-[#737373] group-hover:text-[#171717] transition-colors overflow-hidden">
                        @if($category->image_url)
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold mb-0.5">{{ $category->name }}</h3>
                        <span class="text-xs text-[#737373]">مشاهده همه</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ==================== POPULAR PRODUCTS ==================== --}}
    <section class="max-w-[1260px] mx-auto px-6 lg:px-8 pb-16">
        {{-- Section Header --}}
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xl lg:text-2xl font-bold">محصولات محبوب</h2>
            <a href="#" class="text-sm text-[#737373] hover:text-[#171717] transition-colors flex items-center gap-1">
                مشاهده همه
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($products as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="bg-white border border-[#E5E5E5] rounded-[14px] overflow-hidden hover:border-[#d4d4d4] hover:-translate-y-1 transition-all duration-200 group block">
                    {{-- Image --}}
                    <div class="relative aspect-square bg-[#FAFAF9]">
                        @if($product->image_url)
                            <img
                                src="{{ $product->image_url }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center text-[#737373]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div class="p-3">
                        <h3 class="text-xs font-medium mb-2 truncate">{{ $product->name }}</h3>
                        <p class="text-sm font-bold mb-3">{{ number_format($product->price) }} <span class="text-[10px] font-normal text-[#737373]">تومان</span></p>
                        <div class="w-full text-xs font-medium py-2 border border-[#E5E5E5] rounded-lg text-center hover:bg-[#171717] hover:text-white hover:border-[#171717] transition-all">
                            مشاهده محصول
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ==================== NEWSLETTER ==================== --}}
    <section class="bg-[#FAFAF9]">
        <div class="max-w-[1260px] mx-auto px-6 lg:px-8 py-14">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="text-center lg:text-right">
                    <h2 class="text-lg lg:text-xl font-bold mb-2">از جدیدترین محصولات باخبر شوید</h2>
                    <p class="text-sm text-[#737373]">برای اطلاع از محصولات و تخفیف‌های جدید عضو شوید.</p>
                </div>
                <div class="flex w-full lg:w-auto gap-3">
                    <input
                        type="email"
                        placeholder="ایمیل خود را وارد کنید"
                        class="flex-1 lg:w-[320px] px-4 py-3 text-sm border border-[#E5E5E5] rounded-lg bg-white focus:outline-none focus:border-[#171717] transition-colors"
                    >
                    <button class="bg-[#171717] text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-[#2a2a2a] transition-colors shrink-0">
                        عضویت
                    </button>
                </div>
            </div>
        </div>
    </section>

@endsection

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
        @php
            $categories = [
                ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.048 8.287 8.287 0 0 0 9 9.6a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z" /></svg>', 'title' => 'سیگار'],
                ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19 14.5M14.25 3.104c.251.023.501.05.75.082M19 14.5l-1.07 4.28a1.125 1.125 0 0 1-1.08.72H7.15a1.125 1.125 0 0 1-1.08-.72L5 14.5m14 0H5" /></svg>', 'title' => 'سیگار برگ'],
                ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>', 'title' => 'ویپ'],
                ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" /></svg>', 'title' => 'لوازم جانبی'],
            ];
        @endphp

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($categories as $category)
                <a href="#" class="bg-white border border-[#E5E5E5] rounded-2xl p-5 flex items-center gap-4 hover:border-[#d4d4d4] transition-colors group">
                    <div class="w-12 h-12 rounded-xl bg-[#FAFAF9] flex items-center justify-center text-[#737373] group-hover:text-[#171717] transition-colors">
                        {!! $category['icon'] !!}
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold mb-0.5">{{ $category['title'] }}</h3>
                        <span class="text-xs text-[#737373]">مشاهده همه</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ==================== POPULAR PRODUCTS ==================== --}}
    <section class="max-w-[1260px] mx-auto px-6 lg:px-8 pb-16">
        @php
            $products = [
                ['name' => 'Marlboro Gold', 'price' => '۲۸۵,۰۰۰', 'image' => 'https://images.unsplash.com/photo-1602856276035-d2e985f5a8b4?w=400&h=400&fit=crop&crop=center'],
                ['name' => 'Marlboro Red', 'price' => '۲۷۵,۰۰۰', 'image' => 'https://images.unsplash.com/photo-1574100004036-f0807f203864?w=400&h=400&fit=crop&crop=center'],
                ['name' => 'Parliament Aqua Blue', 'price' => '۳۱۰,۰۰۰', 'image' => 'https://images.unsplash.com/photo-1612528443702-f6741f70a049?w=400&h=400&fit=crop&crop=center'],
                ['name' => 'Winston Blue', 'price' => '۲۴۵,۰۰۰', 'image' => 'https://images.unsplash.com/photo-1550439062-609e1531270e?w=400&h=400&fit=crop&crop=center'],
                ['name' => 'Camel Yellow', 'price' => '۲۶۵,۰۰۰', 'image' => 'https://images.unsplash.com/photo-1603905179985-270fd86a2983?w=400&h=400&fit=crop&crop=center'],
                ['name' => 'Davidoff Gold', 'price' => '۳۹۵,۰۰۰', 'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=400&fit=crop&crop=center'],
            ];
        @endphp

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
                <div class="bg-white border border-[#E5E5E5] rounded-[14px] overflow-hidden hover:border-[#d4d4d4] hover:-translate-y-1 transition-all duration-200 group">
                    {{-- Image --}}
                    <div class="relative aspect-square bg-[#FAFAF9]">
                        <img
                            src="{{ $product['image'] }}"
                            alt="{{ $product['name'] }}"
                            class="w-full h-full object-cover"
                        >
                        {{-- Heart --}}
                        <button class="absolute top-3 left-3 p-1.5 text-[#a3a3a3] hover:text-red-500 transition-colors" aria-label="افزودن به علاقه‌مندی‌ها">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </button>
                    </div>
                    {{-- Info --}}
                    <div class="p-3">
                        <h3 class="text-xs font-medium mb-2 truncate">{{ $product['name'] }}</h3>
                        <p class="text-sm font-bold mb-3">{{ $product['price'] }} <span class="text-[10px] font-normal text-[#737373]">تومان</span></p>
                        <button class="w-full text-xs font-medium py-2 border border-[#E5E5E5] rounded-lg hover:bg-[#171717] hover:text-white hover:border-[#171717] transition-all">
                            افزودن به سبد
                        </button>
                    </div>
                </div>
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

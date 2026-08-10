@extends('2khanonline.layout.main')

@section('title', 'تماس با Smokify | اسموکیفای شیراز')
@section('seo_title', 'تماس با Smokify | اسموکیفای در شیراز')
@section('seo_description', 'راه‌های ارتباط با فروشگاه Smokify | اسموکیفای در شیراز برای مشاوره و پیگیری خرید سیگار آنلاین، ویپ، جویس و زغال.')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #contactMap { height: 360px; border-radius: 0.75rem; z-index: 1; }
        .leaflet-container { direction: ltr; }
    </style>
@endpush

@section('content')

    @php
        $hasContactInfo = filled($contactUs->address ?? null)
            || (filled($telegram) && $telegramUrl)
            || (filled($whatsApp) && $whatsAppUrl)
            || $hasLocation;
    @endphp

    <section class="pt-8 pb-16">
        <div class="max-w-[1260px] mx-auto px-6 lg:px-8">
            <div class="bg-white border border-[#E5E5E5] rounded-[20px] p-8 lg:p-12">
                <span class="inline-flex text-xs font-medium text-[#B88A2A] bg-[#B88A2A]/10 px-3 py-1 rounded-full mb-5">ارتباط با ما</span>

                @if (filled($contactUs->title ?? null))
                    <h1 class="text-2xl lg:text-[38px] font-bold leading-tight text-[#171717] mb-4">
                        {{ $contactUs->title }}
                    </h1>
                @endif

                @if (filled($contactUs->description ?? null))
                    <div class="max-w-3xl text-sm lg:text-base text-[#737373] leading-8 [&_a]:text-[#B88A2A] [&_a]:font-medium">
                        {!! $contactUs->description !!}
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if ($hasContactInfo)
        <section class="max-w-[1260px] mx-auto px-6 lg:px-8 pb-20">
            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 space-y-4">
                    @if (filled($contactUs->address ?? null))
                        <div class="bg-white border border-[#E5E5E5] rounded-2xl p-6">
                            <div class="w-12 h-12 rounded-xl bg-[#FAFAF9] flex items-center justify-center text-[#B88A2A] mb-5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </div>
                            <h2 class="text-base font-bold mb-2">آدرس</h2>
                            <p class="text-sm text-[#737373] leading-7">{{ $contactUs->address }}</p>
                        </div>
                    @endif

                    @if (filled($telegram) && $telegramUrl)
                        <a href="{{ $telegramUrl }}" target="_blank" rel="noopener noreferrer" class="block bg-white border border-[#E5E5E5] rounded-2xl p-6 hover:border-[#d4d4d4] hover:-translate-y-0.5 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-[#FAFAF9] flex items-center justify-center text-[#B88A2A] shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-base font-bold mb-1">تلگرام</h2>
                                    <p class="text-sm text-[#737373] break-all">{{ $telegram }}</p>
                                </div>
                            </div>
                        </a>
                    @endif

                    @if (filled($whatsApp) && $whatsAppUrl)
                        <a href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer" class="block bg-white border border-[#E5E5E5] rounded-2xl p-6 hover:border-[#d4d4d4] hover:-translate-y-0.5 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-[#FAFAF9] flex items-center justify-center text-[#B88A2A] shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12c0 5.385 4.365 9.75 9.75 9.75 1.674 0 3.25-.422 4.628-1.166l4.122 1.166-1.166-4.122A9.708 9.708 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75c.4 2.1 1.525 3.225 3.625 3.625" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-base font-bold mb-1">واتساپ</h2>
                                    <p class="text-sm text-[#737373] break-all" dir="ltr">{{ $whatsApp }}</p>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>

                @if ($hasLocation)
                    <div class="lg:col-span-2 bg-white border border-[#E5E5E5] rounded-2xl overflow-hidden min-h-[360px]">
                        <div id="contactMap" class="w-full h-[360px] lg:h-full min-h-[360px]"></div>
                    </div>
                @endif
            </div>
        </section>
    @endif

@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if ($hasLocation)
                var lat = {{ $lat }};
                var lng = {{ $lng }};

                var map = L.map('contactMap').setView([lat, lng], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    maxZoom: 19,
                }).addTo(map);

                L.marker([lat, lng]).addTo(map);

                setTimeout(function () { map.invalidateSize(); }, 300);
            @endif
        });
    </script>
@endpush

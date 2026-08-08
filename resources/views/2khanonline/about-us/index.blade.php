@extends('2khanonline.layout.main')

@section('title', 'درباره ما | دو خان')

@section('content')

    <section class="pt-8 pb-16">
        <div class="max-w-[1260px] mx-auto px-6 lg:px-8">
            <div class="bg-white border border-[#E5E5E5] rounded-[20px] overflow-hidden">
                <div class="grid {{ $imageUrl ? 'lg:grid-cols-2' : 'lg:grid-cols-1' }} gap-0 items-stretch">
                    <div class="p-8 lg:p-12 flex flex-col justify-center">
                        <span class="inline-flex w-fit text-xs font-medium text-[#B88A2A] bg-[#B88A2A]/10 px-3 py-1 rounded-full mb-5">درباره دو خان</span>

                        @if (filled($aboutUs->title ?? null))
                            <h1 class="text-2xl lg:text-[38px] font-bold leading-tight text-[#171717]">
                                {{ $aboutUs->title }}
                            </h1>
                        @endif
                    </div>

                    @if ($imageUrl)
                        <div class="relative min-h-[260px] lg:min-h-[420px] bg-[#FAFAF9]">
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $aboutUs->title ?? 'درباره دو خان' }}"
                                class="absolute inset-0 w-full h-full object-cover"
                            >
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if (filled($aboutUs->description ?? null))
        <section class="max-w-[980px] mx-auto px-6 lg:px-8 pb-20">
            <div class="bg-white border border-[#E5E5E5] rounded-2xl p-6 lg:p-10">
                <div class="space-y-5 text-sm lg:text-base text-[#525252] leading-8 lg:leading-9 [&_h1]:text-2xl [&_h1]:font-bold [&_h1]:text-[#171717] [&_h2]:text-xl [&_h2]:font-bold [&_h2]:text-[#171717] [&_h3]:text-lg [&_h3]:font-semibold [&_h3]:text-[#171717] [&_p]:leading-8 [&_a]:text-[#B88A2A] [&_a]:font-medium [&_ul]:list-disc [&_ul]:pr-6 [&_ol]:list-decimal [&_ol]:pr-6 [&_li]:mb-2">
                    {!! $aboutUs->description !!}
                </div>
            </div>
        </section>
    @endif

@endsection

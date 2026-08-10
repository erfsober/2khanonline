<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        @php
            $seoTitle = trim($__env->yieldContent('seo_title', config('store.brand') . ' | فروشگاه آنلاین محصولات دخانیات'));
            $seoDescription = trim($__env->yieldContent('seo_description', config('store.description')));
            $seoImage = trim($__env->yieldContent('seo_image', asset('images/main.png')));
            $seoRobots = trim($__env->yieldContent('seo_robots', 'index,follow'));
            $canonicalUrl = url()->current();
            $seoKeywords = implode(', ', config('store.seo_keywords', []));
            $organizationSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => config('store.brand'),
                'alternateName' => [config('store.brand_en'), config('store.brand_fa')],
                'url' => url('/'),
                'logo' => asset('favicon.ico'),
                'areaServed' => ['@type' => 'City', 'name' => config('store.city')],
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => config('store.city'),
                    'addressCountry' => 'IR',
                ],
            ];
        @endphp
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $seoDescription }}">
        <meta name="keywords" content="{{ $seoKeywords }}">
        <meta name="robots" content="{{ $seoRobots }}">
        <link rel="canonical" href="{{ $canonicalUrl }}">
        <meta property="og:locale" content="fa_IR">
        <meta property="og:type" content="@yield('og_type', 'website')">
        <meta property="og:title" content="{{ $seoTitle }}">
        <meta property="og:description" content="{{ $seoDescription }}">
        <meta property="og:url" content="{{ $canonicalUrl }}">
        <meta property="og:site_name" content="{{ config('store.brand') }}">
        <meta property="og:image" content="{{ $seoImage }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $seoTitle }}">
        <meta name="twitter:description" content="{{ $seoDescription }}">
        <meta name="twitter:image" content="{{ $seoImage }}">
        <title>@yield('title', config('store.brand') . ' | فروشگاه آنلاین')</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <script type="application/ld+json">
            @json($organizationSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        </script>
        @stack('seo')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Vazirmatn', ui-sans-serif, system-ui, sans-serif; }
        </style>
        @stack('styles')
    </head>
    <body class="bg-[#FAFAF9] text-[#171717] min-h-screen">

        @include('2khanonline.layout.header')

        <main>
            @yield('content')
        </main>

        @include('2khanonline.layout.footer')

        @stack('scripts')
    </body>
</html>

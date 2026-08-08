<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'دو خان | فروشگاه آنلاین')</title>
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

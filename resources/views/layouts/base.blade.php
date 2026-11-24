<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
    <title>@yield('title', config('app.name', 'CurtissTax') . ' – ' . __('app.tagline'))</title>
    <meta name="title" content="@yield('title', config('app.name', 'CurtissTax') . ' – ' . __('app.tagline'))">
    <meta name="description" content="@yield('meta_description', 'CurtissTax is Sri Lanka\'s premier trilingual cloud tax invoicing and business document management platform for VAT and non-VAT businesses.')">
    <meta name="keywords" content="Sri Lanka tax invoice, VAT invoice Sri Lanka, IRD tax invoice, e-invoicing Sri Lanka, CurtissTax, LKR invoicing, RAMIS Sri Lanka">
    <meta name="author" content="CurtissTax">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', config('app.name', 'CurtissTax') . ' – ' . __('app.tagline'))">
    <meta property="og:description" content="@yield('meta_description', 'Trilingual cloud tax invoicing platform for Sri Lankan VAT and non-VAT businesses. 14-day free trial.')">
    <meta property="og:site_name" content="CurtissTax">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', config('app.name', 'CurtissTax'))">
    <meta name="twitter:description" content="@yield('meta_description', 'Trilingual cloud tax invoicing platform for Sri Lankan businesses.')">

    <!-- Google Fonts: Inter & Sinhala/Tamil Unicode support -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+Sinhala:wght@400;500;600;700&family=Noto+Sans+Tamil:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-neutral-950 text-neutral-100 min-h-screen font-sans selection:bg-neutral-800 selection:text-white antialiased flex flex-col">
    @yield('body')

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.renderLucide) {
                window.renderLucide();
            }
        });
    </script>
</body>
</html>

@php
    $pageTitle = trim($__env->yieldContent('title')) ?: 'IntegraTaller — Software de gestión para talleres mecánicos';
    $pageDesc = trim($__env->yieldContent('meta_description')) ?: 'Software de gestión para talleres mecánicos en Argentina. Turnos, órdenes de trabajo, stock y presupuestos en la nube. Precios en pesos.';
    $canonical = trim($__env->yieldContent('canonical')) ?: url()->current();
    $ogImage = asset(config('landing.og_image', 'og-image.png'));
@endphp
<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#007BFF">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <link rel="canonical" href="{{ $canonical }}">
    <meta name="robots" content="@yield('robots', 'index, follow, max-image-preview:large')">

    {{-- Open Graph --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ config('landing.site_name', 'IntegraTaller') }}">
    <meta property="og:locale" content="es_AR">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="IntegraTaller — software de gestión para talleres mecánicos">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDesc }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Lato:wght@400;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('partials.schema')
    @stack('head')
</head>
<body class="min-h-[100dvh] bg-white text-secondary">
    <a href="#contenido"
       class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[500] focus:rounded-sm focus:bg-primary focus:px-4 focus:py-2 focus:text-white">
        Saltar al contenido
    </a>

    @include('partials.beta-bar')
    @include('partials.header')

    <main id="contenido">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.whatsapp-float')

    @stack('scripts')
</body>
</html>

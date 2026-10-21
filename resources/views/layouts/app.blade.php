@php
    $pageTitle = trim($__env->yieldContent('title')) ?: 'IntegraTaller | Tu taller, en orden.';
    $pageDesc = trim($__env->yieldContent('meta_description')) ?: 'Sistema de gestión para talleres mecánicos y de estética vehicular. Órdenes de trabajo, clientes y finanzas de todas tus sucursales en un solo lugar.';
    $canonical = trim($__env->yieldContent('canonical')) ?: url()->current();
    $ogImage = asset(config('landing.og_image', 'og-image.png'));
@endphp
<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0B2A5B">
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
    <meta property="og:image:alt" content="IntegraTaller — Tu taller, en orden.">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDesc }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/svg+xml" href="{{ asset('brand/isotipo-color.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">

    <link rel="preload" href="{{ asset('fonts/poppins-regular.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('fonts/poppins-bold.woff2') }}" as="font" type="font/woff2" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('partials.schema')
    @stack('head')
</head>
<body class="min-h-[100dvh]">
    <a href="#contenido"
       class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[500] focus:rounded-md focus:bg-primario focus:px-4 focus:py-2 focus:text-white">
        Saltar al contenido
    </a>

    @include('partials.header')

    <main id="contenido">
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.whatsapp-float')

    @unless (request()->routeIs('contacto'))
        @include('partials.demo-dialog')
    @endunless

    @include('partials.analytics')

    @stack('scripts')
</body>
</html>

@extends('layouts.app')

@section('title', $city['title'])
@section('meta_description', $city['meta_description'])
@section('canonical', route('cities.show', $slug))

@php
    $otherCities = collect(config('seo.cities'))->except($slug);
    $benefits = [
        ['title' => 'Turnos y clientes', 'text' => 'Consultá la agenda del taller y el historial de cada vehículo.'],
        ['title' => 'Órdenes de trabajo', 'text' => 'Registrá los trabajos y seguí el estado de cada orden.'],
        ['title' => 'Stock de repuestos', 'text' => 'Mantené visibles los repuestos y consumibles del taller.'],
        ['title' => 'Presupuestos', 'text' => 'Compartí las cotizaciones con tus clientes por WhatsApp.'],
    ];
@endphp

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <nav class="mb-8 text-sm text-secondary/65" aria-label="Migas de pan">
                <a href="{{ route('home') }}" class="underline-offset-4 hover:text-primary hover:underline">Inicio</a>
                <span class="mx-2">/</span>
                <a href="{{ route('cities.index') }}" class="underline-offset-4 hover:text-primary hover:underline">Talleres por ciudad</a>
                <span class="mx-2">/</span>
                <span aria-current="page" class="text-secondary">{{ $city['name'] }}</span>
            </nav>
            <p class="section-kicker">{{ $city['province'] }}</p>
            <h1 class="display-title mt-5 max-w-[12ch]">{{ $city['h1'] }}</h1>
            <p class="mt-6 max-w-[58ch] text-lg leading-relaxed text-secondary/75">{{ $city['intro'] }}</p>
            <a href="{{ route('contacto') }}" class="btn btn-primary mt-8" data-cta="demo">Solicitar una demo</a>
        </div>
    </section>

    <section class="bg-white">
        <div class="container-page section-gap">
            <p class="section-kicker">Para el trabajo diario</p>
            <h2 class="section-title mt-5 max-w-[14ch]">Una operación más fácil de seguir.</h2>
            <div class="mt-9 grid gap-x-10 border-t-2 border-secondary sm:grid-cols-2">
                @foreach ($benefits as $benefit)
                    <article class="border-b border-line py-5">
                        <h3 class="font-display text-3xl font-semibold">{{ $benefit['title'] }}</h3>
                        <p class="mt-2 max-w-[50ch] text-secondary/70">{{ $benefit['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-y border-line bg-neutral">
        <div class="container-page grid gap-10 py-10 sm:grid-cols-[1fr_1.1fr] sm:items-center sm:py-12">
            <div>
                <p class="section-kicker">Seguimos conectando talleres</p>
                <h2 class="mt-4 font-display text-4xl font-semibold">Conocé el sistema desde {{ $city['name'] }}.</h2>
            </div>
            <div class="flex flex-wrap gap-x-5 gap-y-3">
                @foreach (config('seo.features') as $featureSlug => $feature)
                    <a href="{{ route('features.show', $featureSlug) }}" class="font-bold text-primary underline decoration-primary/30 underline-offset-4 hover:decoration-primary">{{ $feature['label'] ?? $feature['h1'] }}</a>
                @endforeach
            </div>
        </div>
    </section>

    @if ($otherCities->isNotEmpty())
        <section class="bg-white">
            <div class="container-page py-10">
                <h2 class="font-display text-3xl font-semibold">También en otras ciudades</h2>
                <div class="mt-4 flex flex-wrap gap-x-6 gap-y-3">
                    @foreach ($otherCities as $otherSlug => $other)
                        <a href="{{ route('cities.show', $otherSlug) }}" class="font-bold text-primary underline decoration-primary/30 underline-offset-4 hover:decoration-primary">Talleres en {{ $other['name'] }}</a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="bg-primary-deep py-12 text-white sm:py-16">
        <div class="container-page flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <h2 class="max-w-[15ch] font-display text-5xl font-semibold leading-none text-white sm:text-6xl">Veamos qué necesita tu taller.</h2>
            <a href="{{ route('contacto') }}" class="btn btn-light shrink-0" data-cta="demo">Solicitar una demo</a>
        </div>
    </section>
@endsection

@push('head')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $city['h1'],
            'description' => $city['meta_description'],
            'provider' => ['@type' => 'Organization', 'name' => 'IntegraTaller', 'url' => url('/')],
            'areaServed' => [
                '@type' => 'City',
                'name' => $city['name'],
                'address' => ['@type' => 'PostalAddress', 'addressRegion' => $city['province'], 'addressCountry' => 'AR'],
            ],
            'url' => route('cities.show', $slug),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Inicio', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Talleres', 'item' => route('cities.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $city['name'], 'item' => route('cities.show', $slug)],
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

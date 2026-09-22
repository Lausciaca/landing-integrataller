@extends('layouts.app')

@section('title', $city['title'])
@section('meta_description', $city['meta_description'])
@section('canonical', route('cities.show', $slug))

@php
    $cotizar = config('landing.app_url');
    $whatsapp = 'https://wa.me/' . config('landing.whatsapp') . '?text=' . rawurlencode(config('landing.whatsapp_message'));
    $otherCities = collect(config('seo.cities'))->except($slug);
    $benefits = [
        ['icon' => 'calendar', 'title' => 'Turnos ordenados', 'text' => 'Agenda del taller sin superposiciones, con aviso al cliente por WhatsApp.'],
        ['icon' => 'history', 'title' => 'Historial por patente', 'text' => 'Todo lo que se le hizo a cada vehículo, a un clic de distancia.'],
        ['icon' => 'package', 'title' => 'Stock de repuestos', 'text' => 'Controlá aceite, filtros y piezas con alertas de bajo stock.'],
        ['icon' => 'receipt', 'title' => 'Presupuestos en 2 clics', 'text' => 'Armá la cotización y enviala por WhatsApp para que la aprueben.'],
    ];
@endphp

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <nav class="mb-6 text-sm text-secondary/70" aria-label="Migas de pan">
                <a href="{{ route('home') }}" class="hover:text-primary">Inicio</a>
                <span class="mx-2">/</span>
                <a href="{{ route('cities.index') }}" class="hover:text-primary">Talleres</a>
                <span class="mx-2">/</span>
                <span class="text-secondary">{{ $city['name'] }}</span>
            </nav>

            <x-section-heading
                level="h1"
                align="left"
                eyebrow="{{ $city['province'] }}"
                :title="$city['h1']"
                :subtitle="$city['intro']"
            />

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $cotizar }}" class="btn btn-primary px-7 py-4 text-lg" data-cta="cotizar">
                    Cotizá tu sistema ahora
                    <x-icon name="arrow-right" class="h-5 w-5" />
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp px-7 py-4 text-lg">
                    <x-icon name="whatsapp" class="h-5 w-5" />
                    Hablar con un asesor
                </a>
            </div>
        </div>
    </section>

    <section class="border-b border-line bg-white">
        <div class="container-page section-gap">
            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">Qué resuelve IntegraTaller en {{ $city['name'] }}</h2>
            <div class="mt-8 grid gap-6 sm:grid-cols-2">
                @foreach ($benefits as $benefit)
                    <article class="card flex flex-col">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-sm bg-primary/10 text-primary">
                            <x-icon :name="$benefit['icon']" class="h-6 w-6" />
                        </span>
                        <h3 class="mt-4 text-xl font-bold">{{ $benefit['title'] }}</h3>
                        <p class="mt-2 leading-relaxed text-secondary/70">{{ $benefit['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <h2 class="text-2xl font-bold tracking-tight">Características del software</h2>
            <ul class="mt-6 flex flex-wrap gap-3">
                @foreach (config('seo.features') as $featureSlug => $feature)
                    <li>
                        <a href="{{ route('features.show', $featureSlug) }}"
                           class="badge border border-line bg-white px-4 py-2 text-primary transition hover:border-primary/40">
                            {{ $feature['label'] ?? $feature['h1'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            @if ($otherCities->isNotEmpty())
                <h2 class="mt-12 text-2xl font-bold tracking-tight">Talleres en otras ciudades</h2>
                <ul class="mt-6 flex flex-wrap gap-3">
                    @foreach ($otherCities as $otherSlug => $other)
                        <li>
                            <a href="{{ route('cities.show', $otherSlug) }}"
                               class="badge border border-line bg-white px-4 py-2 text-primary transition hover:border-primary/40">
                                {{ $other['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>

    <section class="bg-primary text-white">
        <div class="container-page section-gap text-center">
            <h2 class="mx-auto max-w-2xl text-3xl font-black tracking-tight text-white sm:text-4xl">
                Activá tu software de taller en {{ $city['name'] }} hoy.
            </h2>
            <a href="{{ $cotizar }}" class="btn btn-inverse mt-8 px-7 py-4 text-lg" data-cta="cotizar">
                Ir al Cotizador
                <x-icon name="arrow-right" class="h-5 w-5" />
            </a>
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

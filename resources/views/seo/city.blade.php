@extends('layouts.app')

@section('title', $city['title'])
@section('meta_description', $city['meta_description'])
@section('canonical', route('cities.show', $slug))

@php
    $otherCities = collect(config('seo.cities'))->except($slug);
    $benefits = [
        ['icon' => 'calendar', 'title' => 'Turnos y clientes', 'text' => 'La agenda del taller y el historial de cada vehículo a mano.'],
        ['icon' => 'clipboard', 'title' => 'Órdenes de trabajo', 'text' => 'Cada trabajo registrado, con su estado al día.'],
        ['icon' => 'package', 'title' => 'Stock de repuestos', 'text' => 'Repuestos y consumibles a la vista.'],
        ['icon' => 'send', 'title' => 'Presupuestos', 'text' => 'Mandá el presupuesto al cliente por WhatsApp.'],
    ];
@endphp

@section('content')
    <x-page-header :eyebrow="$city['province']" :title="$city['h1']" :subtitle="$city['intro']">
        <x-slot:breadcrumbs>
            <x-breadcrumbs :items="['Inicio' => route('home'), 'Talleres por ciudad' => route('cities.index'), $city['name'] => null]" />
        </x-slot:breadcrumbs>
        <a href="{{ route('contacto') }}" class="boton boton-principal mt-8" data-cta="demo">Pedí tu demo</a>
    </x-page-header>

    <section class="seccion bg-white">
        <div class="contenedor">
            <x-section-heading eyebrow="Para el día a día" title="Un taller más fácil de seguir." />
            <div class="mt-10 grid gap-x-8 gap-y-10 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($benefits as $benefit)
                    <article>
                        <x-icon :name="$benefit['icon']" class="h-8 w-8 text-celeste-500" />
                        <h3 class="t-titulo-3 mt-4">{{ $benefit['title'] }}</h3>
                        <p class="mt-2 text-texto-secundario">{{ $benefit['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="seccion bg-gris-50">
        <div class="contenedor grid gap-10 md:grid-cols-2">
            <div>
                <h2 class="t-titulo-3">Funciones del sistema</h2>
                <ul class="mt-4 space-y-2">
                    @foreach (config('seo.features') as $featureSlug => $feature)
                        <li><a href="{{ route('features.show', $featureSlug) }}" class="enlace">{{ $feature['label'] ?? $feature['h1'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            @if ($otherCities->isNotEmpty())
                <div>
                    <h2 class="t-titulo-3">También en otras ciudades</h2>
                    <ul class="mt-4 space-y-2">
                        @foreach ($otherCities as $otherSlug => $other)
                            <li><a href="{{ route('cities.show', $otherSlug) }}" class="enlace">Talleres en {{ $other['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>

    <x-cierre title="Veamos qué necesita tu taller." />
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

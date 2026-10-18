@extends('layouts.app')

@section('title', $feature['title'])
@section('meta_description', $feature['meta_description'])
@section('canonical', route('features.show', $slug))

@php
    $others = collect(config('seo.features'))->except($slug);
@endphp

@section('content')
    <x-page-header :eyebrow="$feature['label'] ?? 'Función'" :title="$feature['h1']" :subtitle="$feature['meta_description']">
        <x-slot:breadcrumbs>
            <x-breadcrumbs :items="['Inicio' => route('home'), 'Funciones' => route('features.index'), ($feature['label'] ?? $feature['h1']) => null]" />
        </x-slot:breadcrumbs>
        <a href="{{ route('contacto') }}" class="boton boton-principal mt-8" data-cta="demo">Pedí tu demo</a>
    </x-page-header>

    <section class="seccion bg-white">
        <div class="contenedor grid gap-10 md:grid-cols-[0.9fr_1.1fr] md:gap-16">
            <div>
                <p class="t-etiqueta">El problema</p>
                <h2 class="t-titulo-2 mt-3">{{ $feature['pain'] }}</h2>
            </div>
            <div class="tarjeta border border-borde">
                <p class="t-etiqueta">Cómo te ayuda</p>
                <p class="t-cuerpo-grande mt-3">{{ $feature['solution'] }}</p>
                <ul class="mt-6 space-y-3">
                    @foreach ($feature['bullets'] as $bullet)
                        <li class="flex items-start gap-3">
                            <x-icon name="check" class="mt-0.5 h-5 w-5 shrink-0 text-exito" />
                            <span>{{ $bullet }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    @if ($others->isNotEmpty())
        <section class="seccion bg-gris-50">
            <div class="contenedor">
                <x-section-heading eyebrow="También podés ver" title="Otras funciones del sistema" />
                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    @foreach ($others as $otherSlug => $other)
                        <a href="{{ route('features.show', $otherSlug) }}" class="tarjeta group transition-shadow hover:shadow-2">
                            <span class="t-titulo-3 text-azul-800">{{ $other['label'] ?? $other['h1'] }}</span>
                            <p class="t-cuerpo-chico mt-2 text-texto-secundario">{{ $other['meta_description'] }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-cierre title="Mirá esta función en tu taller." />
@endsection

@push('head')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $feature['h1'],
            'description' => $feature['meta_description'],
            'provider' => ['@type' => 'Organization', 'name' => 'IntegraTaller', 'url' => url('/')],
            'areaServed' => ['@type' => 'Country', 'name' => 'Argentina'],
            'url' => route('features.show', $slug),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Inicio', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Funciones', 'item' => route('features.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $feature['label'] ?? $feature['h1'], 'item' => route('features.show', $slug)],
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

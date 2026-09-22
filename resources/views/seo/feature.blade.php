@extends('layouts.app')

@section('title', $feature['title'])
@section('meta_description', $feature['meta_description'])
@section('canonical', route('features.show', $slug))
@section('og_type', 'article')

@php
    $cotizar = config('landing.app_url');
    $whatsapp = 'https://wa.me/' . config('landing.whatsapp') . '?text=' . rawurlencode(config('landing.whatsapp_message'));
    $others = collect(config('seo.features'))->except($slug);
@endphp

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <nav class="mb-6 text-sm text-secondary/70" aria-label="Migas de pan">
                <a href="{{ route('home') }}" class="hover:text-primary">Inicio</a>
                <span class="mx-2">/</span>
                <a href="{{ route('features.index') }}" class="hover:text-primary">Características</a>
                <span class="mx-2">/</span>
                <span class="text-secondary">{{ $feature['label'] ?? $feature['h1'] }}</span>
            </nav>

            <x-section-heading
                level="h1"
                align="left"
                eyebrow="Característica"
                :title="$feature['h1']"
                :subtitle="$feature['meta_description']"
            />

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $cotizar }}" class="btn btn-primary px-7 py-4 text-lg" data-cta="cotizar">
                    Cotizá y activá tu sistema hoy
                    <x-icon name="arrow-right" class="h-5 w-5" />
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp px-7 py-4 text-lg">
                    <x-icon name="whatsapp" class="h-5 w-5" />
                    Consultar por WhatsApp
                </a>
            </div>
        </div>
    </section>

    <section class="border-b border-line bg-white">
        <div class="container-page section-gap grid gap-8 lg:grid-cols-2">
            <div class="card">
                <p class="text-sm font-bold uppercase tracking-[0.14em] text-danger">El problema</p>
                <p class="mt-3 text-xl leading-snug text-secondary/70">{{ $feature['pain'] }}</p>
            </div>

            <div class="card">
                <p class="text-sm font-bold uppercase tracking-[0.14em] text-primary">La solución</p>
                <p class="mt-3 leading-relaxed text-secondary/70">{{ $feature['solution'] }}</p>
                <ul class="mt-4 space-y-2">
                    @foreach ($feature['bullets'] as $bullet)
                        <li class="flex items-center gap-2 text-secondary/80">
                            <x-icon name="check" class="h-4 w-4 text-surface" /> {{ $bullet }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    @if ($others->isNotEmpty())
        <section class="border-b border-line bg-neutral">
            <div class="container-page section-gap">
                <h2 class="text-2xl font-bold tracking-tight">Otras características del software</h2>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($others as $otherSlug => $other)
                        <a href="{{ route('features.show', $otherSlug) }}"
                           class="card group flex flex-col transition duration-200 hover:-translate-y-1 hover:border-primary/40">
                            <h3 class="text-lg font-bold group-hover:text-primary">{{ $other['label'] ?? $other['h1'] }}</h3>
                            <p class="mt-2 flex-1 text-sm leading-relaxed text-secondary/70">{{ $other['meta_description'] }}</p>
                            <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                                Ver más
                                <x-icon name="chevron-right" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5" />
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="bg-primary text-white">
        <div class="container-page section-gap text-center">
            <h2 class="mx-auto max-w-2xl text-3xl font-black tracking-tight text-white sm:text-4xl">
                Sumá {{ strtolower($feature['label'] ?? $feature['h1']) }} a tu taller hoy.
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
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Características', 'item' => route('features.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $feature['label'] ?? $feature['h1'], 'item' => route('features.show', $slug)],
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

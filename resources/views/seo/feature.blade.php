@extends('layouts.app')

@section('title', $feature['title'])
@section('meta_description', $feature['meta_description'])
@section('canonical', route('features.show', $slug))

@php
    $others = collect(config('seo.features'))->except($slug);
@endphp

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <nav class="mb-8 text-sm text-secondary/65" aria-label="Migas de pan">
                <a href="{{ route('home') }}" class="underline-offset-4 hover:text-primary hover:underline">Inicio</a>
                <span class="mx-2">/</span>
                <a href="{{ route('features.index') }}" class="underline-offset-4 hover:text-primary hover:underline">Funciones</a>
                <span class="mx-2">/</span>
                <span aria-current="page" class="text-secondary">{{ $feature['label'] ?? $feature['h1'] }}</span>
            </nav>
            <p class="section-kicker">{{ $feature['label'] ?? 'Función' }}</p>
            <h1 class="display-title mt-5 max-w-[12ch]">{{ $feature['h1'] }}</h1>
            <p class="mt-6 max-w-[58ch] text-lg leading-relaxed text-secondary/75">{{ $feature['meta_description'] }}</p>
            <a href="{{ route('contacto') }}" class="btn btn-primary mt-8" data-cta="demo">Solicitar una demo</a>
        </div>
    </section>

    <section class="bg-white">
        <div class="container-page grid gap-12 py-12 md:grid-cols-[0.85fr_1.15fr] md:gap-20 md:py-16">
            <div>
                <p class="section-kicker">El desafío</p>
                <h2 class="mt-4 font-display text-4xl font-semibold leading-none">{{ $feature['pain'] }}</h2>
            </div>
            <div class="border-t-2 border-secondary pt-5">
                <p class="section-kicker">Cómo ayuda</p>
                <p class="mt-4 max-w-[60ch] text-lg leading-relaxed text-secondary/80">{{ $feature['solution'] }}</p>
                <ul class="mt-7 divide-y divide-line border-y border-line">
                    @foreach ($feature['bullets'] as $bullet)
                        <li class="flex items-start gap-3 py-4">
                            <span class="mt-1 text-surface"><x-icon name="check" class="h-5 w-5" /></span>
                            <span>{{ $bullet }}</span>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('contacto') }}" class="mt-7 inline-flex font-bold text-primary underline decoration-primary/30 underline-offset-4 hover:decoration-primary" data-cta="demo">Ver esta función en una demo</a>
            </div>
        </div>
    </section>

    @if ($others->isNotEmpty())
        <section class="border-y border-line bg-neutral">
            <div class="container-page section-gap">
                <p class="section-kicker">También podés conocer</p>
                <h2 class="mt-4 font-display text-4xl font-semibold">Otras funciones del sistema</h2>
                <div class="mt-7 grid gap-x-8 md:grid-cols-2">
                    @foreach ($others as $otherSlug => $other)
                        <a href="{{ route('features.show', $otherSlug) }}" class="group border-t border-secondary/25 py-5">
                            <span class="font-display text-2xl font-semibold group-hover:text-primary">{{ $other['label'] ?? $other['h1'] }}</span>
                            <p class="mt-2 text-sm leading-relaxed text-secondary/70">{{ $other['meta_description'] }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="bg-primary-deep py-12 text-white sm:py-16">
        <div class="container-page flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <h2 class="max-w-[15ch] font-display text-5xl font-semibold leading-none text-white sm:text-6xl">Conocé cómo funciona en tu taller.</h2>
            <a href="{{ route('contacto') }}" class="btn btn-light shrink-0" data-cta="demo">Solicitar una demo</a>
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
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Funciones', 'item' => route('features.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $feature['label'] ?? $feature['h1'], 'item' => route('features.show', $slug)],
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

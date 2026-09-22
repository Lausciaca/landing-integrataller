@extends('layouts.app')

@section('title', 'Software para talleres mecánicos por ciudad | IntegraTaller')
@section('meta_description', 'IntegraTaller en tu ciudad: software de gestión para talleres mecánicos en Rosario, Córdoba, Buenos Aires y más. Precios en pesos.')
@section('canonical', route('cities.index'))

@php $cotizar = config('landing.app_url'); @endphp

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <x-section-heading
                level="h1"
                eyebrow="Cobertura"
                title="Software para talleres mecánicos en tu ciudad"
                subtitle="Trabajamos con talleres de todo el país. Elegí tu ciudad para ver cómo los ayudamos."
            />
        </div>
    </section>

    <section class="border-b border-line bg-white">
        <div class="container-page section-gap">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($cities as $slug => $city)
                    <a href="{{ route('cities.show', $slug) }}"
                       class="card group flex flex-col transition duration-200 hover:-translate-y-1 hover:border-primary/40">
                        <span class="text-sm font-bold uppercase tracking-[0.14em] text-primary">{{ $city['province'] }}</span>
                        <h2 class="mt-2 text-xl font-bold group-hover:text-primary">Talleres en {{ $city['name'] }}</h2>
                        <p class="mt-2 flex-1 leading-relaxed text-secondary/70">{{ $city['meta_description'] }}</p>
                        <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                            Ver detalle
                            <x-icon name="chevron-right" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5" />
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-primary text-white">
        <div class="container-page section-gap text-center">
            <h2 class="mx-auto max-w-2xl text-3xl font-black tracking-tight text-white sm:text-4xl">
                Estés donde estés, tu taller puede estar ordenado.
            </h2>
            <a href="{{ $cotizar }}" class="btn btn-inverse mt-8 px-7 py-4 text-lg" data-cta="cotizar">
                Ir al Cotizador
                <x-icon name="arrow-right" class="h-5 w-5" />
            </a>
        </div>
    </section>
@endsection

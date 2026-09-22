@extends('layouts.app')

@section('title', 'Características del software para talleres | IntegraTaller')
@section('meta_description', 'Conocé las características de IntegraTaller: control de turnos, historial por patente, control de stock y presupuestos por WhatsApp.')
@section('canonical', route('features.index'))

@php $cotizar = config('landing.app_url'); @endphp

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <x-section-heading
                level="h1"
                eyebrow="Características"
                title="Todo lo que tu taller puede hacer con IntegraTaller"
                subtitle="Módulos pensados para el día a día del taller mecánico. Elegí una característica para ver el detalle."
            />
        </div>
    </section>

    <section class="border-b border-line bg-white">
        <div class="container-page section-gap">
            <div class="grid gap-6 sm:grid-cols-2">
                @foreach ($features as $slug => $feature)
                    <a href="{{ route('features.show', $slug) }}"
                       class="card group flex flex-col transition duration-200 hover:-translate-y-1 hover:border-primary/40">
                        <h2 class="text-xl font-bold group-hover:text-primary">{{ $feature['h1'] }}</h2>
                        <p class="mt-2 flex-1 leading-relaxed text-secondary/70">{{ $feature['meta_description'] }}</p>
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
                Llevá todas las características a tu taller.
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
            '@type' => 'CollectionPage',
            'name' => 'Características del software para talleres',
            'url' => route('features.index'),
            'inLanguage' => 'es-AR',
            'hasPart' => collect($features)->map(fn ($feature) => [
                '@type' => 'Service',
                'name' => $feature['h1'],
                'description' => $feature['meta_description'],
            ])->all(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

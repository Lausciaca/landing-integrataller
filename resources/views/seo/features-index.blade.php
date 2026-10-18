@extends('layouts.app')

@section('title', 'Funciones para talleres | IntegraTaller')
@section('meta_description', 'Explorá cómo IntegraTaller organiza turnos, historial por vehículo, stock y presupuestos para talleres mecánicos.')
@section('canonical', route('features.index'))

@section('content')
    <x-page-header eyebrow="Funciones" title="Cada parte del taller, ordenada." subtitle="Mirá cómo IntegraTaller conecta turnos, vehículos, órdenes y repuestos." />

    <section class="seccion bg-white">
        <div class="contenedor">
            <div class="grid gap-6 md:grid-cols-2">
                @foreach ($features as $slug => $feature)
                    <a href="{{ route('features.show', $slug) }}" class="group flex flex-col rounded-lg border border-borde p-6 transition-shadow hover:shadow-2 sm:p-8">
                        <p class="t-etiqueta">{{ $feature['label'] ?? 'Función' }}</p>
                        <h2 class="t-titulo-3 mt-3 text-azul-800">{{ $feature['h1'] }}</h2>
                        <p class="mt-2 flex-1 text-texto-secundario">{{ $feature['meta_description'] }}</p>
                        <span class="mt-5 inline-flex items-center gap-2 font-medium text-enlace group-hover:text-azul-800">
                            Ver esta función
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <x-cierre />
@endsection

@push('head')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Funciones para talleres mecánicos',
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

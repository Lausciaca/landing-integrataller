@extends('layouts.app')

@section('title', 'Funciones para talleres mecánicos | IntegraTaller')
@section('meta_description', 'Explorá cómo IntegraTaller organiza turnos, historial por vehículo, stock y presupuestos para talleres mecánicos.')
@section('canonical', route('features.index'))

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <p class="section-kicker">Funciones</p>
            <h1 class="display-title mt-5 max-w-[12ch]">Una vista clara del trabajo del taller.</h1>
            <p class="mt-6 max-w-[58ch] text-lg leading-relaxed text-secondary/75">Explorá las herramientas que conectan turnos, vehículos, órdenes y repuestos.</p>
        </div>
    </section>

    <section class="bg-white">
        <div class="container-page section-gap">
            <div class="grid gap-x-10 border-t-2 border-secondary md:grid-cols-2">
                @foreach ($features as $slug => $feature)
                    <a href="{{ route('features.show', $slug) }}" class="group border-b border-line py-6">
                        <h2 class="font-display text-3xl font-semibold group-hover:text-primary sm:text-4xl">{{ $feature['h1'] }}</h2>
                        <p class="mt-3 max-w-[55ch] leading-relaxed text-secondary/70">{{ $feature['meta_description'] }}</p>
                        <span class="mt-4 inline-flex font-bold text-primary underline decoration-primary/30 underline-offset-4 group-hover:decoration-primary">Conocer esta función</span>
                    </a>
                @endforeach
            </div>
            <a href="{{ route('contacto') }}" class="btn btn-primary mt-9" data-cta="demo">Solicitar una demo</a>
        </div>
    </section>
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

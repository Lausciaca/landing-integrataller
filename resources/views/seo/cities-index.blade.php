@extends('layouts.app')

@section('title', 'Software para talleres mecánicos por ciudad | IntegraTaller')
@section('meta_description', 'Conocé IntegraTaller: software de gestión para talleres mecánicos de Rosario, Córdoba, Buenos Aires y otras ciudades.')
@section('canonical', route('cities.index'))

@section('content')
    <x-page-header eyebrow="Talleres de Argentina" title="Tu taller, en orden, estés donde estés." subtitle="Conocé cómo IntegraTaller ayuda a talleres de tu ciudad." />

    <section class="seccion bg-white">
        <div class="contenedor grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($cities as $slug => $city)
                <a href="{{ route('cities.show', $slug) }}" class="group flex flex-col rounded-lg border border-borde p-6 transition-shadow hover:shadow-2">
                    <p class="t-etiqueta">{{ $city['province'] }}</p>
                    <h2 class="t-titulo-3 mt-3 text-azul-800">Talleres en {{ $city['name'] }}</h2>
                    <p class="t-cuerpo-chico mt-2 flex-1 text-texto-secundario">{{ $city['meta_description'] }}</p>
                    <span class="mt-5 inline-flex items-center gap-2 font-medium text-enlace group-hover:text-azul-800">
                        Ver más
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    <x-cierre />
@endsection

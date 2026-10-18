@extends('layouts.app')

@section('title', 'Guías prácticas para talleres | IntegraTaller')
@section('meta_description', 'Guías prácticas para ordenar órdenes de trabajo, stock, caja y equipo en tu taller mecánico o de estética vehicular.')

@php
    $guides = [
        ['icon' => 'calendar', 'title' => 'Recibir autos y armar la agenda'],
        ['icon' => 'clipboard', 'title' => 'Mantener las órdenes al día'],
        ['icon' => 'package', 'title' => 'Controlar los repuestos'],
        ['icon' => 'send', 'title' => 'Compartir presupuestos con clientes'],
    ];
@endphp

@section('content')
    <x-page-header eyebrow="Guías" title="Ideas prácticas para que el taller funcione." subtitle="Estamos preparando guías claras para los problemas de todos los días. Suscribite y te avisamos cuando estén listas." />

    <section class="seccion bg-white">
        <div class="contenedor">
            <x-section-heading eyebrow="Próximos temas" title="Lo que vas a poder leer." />
            <ul class="mt-10 grid gap-4 sm:grid-cols-2">
                @foreach ($guides as $guide)
                    <li class="flex items-center gap-4 rounded-lg border border-borde p-5">
                        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-azul-50 text-azul-800">
                            <x-icon :name="$guide['icon']" class="h-5 w-5" />
                        </span>
                        <span class="t-titulo-3 text-azul-800">{{ $guide['title'] }}</span>
                        <x-estado tipo="neutro" class="ml-auto hidden sm:inline-flex">Pronto</x-estado>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section id="newsletter" class="seccion bg-gris-50">
        <div class="contenedor grid gap-8 md:grid-cols-2 md:items-center md:gap-16">
            <x-section-heading eyebrow="Sin mensajes de más" title="Te avisamos cuando salga una guía nueva." subtitle="Un email por mes con contenido práctico y novedades. Confirmás tu dirección antes de recibirlo." />
            <div class="tarjeta">
                @include('partials.newsletter-form', ['source' => 'guias'])
            </div>
        </div>
    </section>

    <x-cierre title="¿Preferís ver el sistema primero?" text="Te mostramos cómo funciona con el trabajo de tu taller." />
@endsection

@push('head')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Guías prácticas para talleres',
            'url' => route('tutoriales'),
            'inLanguage' => 'es-AR',
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

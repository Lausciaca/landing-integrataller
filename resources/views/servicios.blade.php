@extends('layouts.app')

@section('title', 'Funciones para talleres mecánicos y de estética | IntegraTaller')
@section('meta_description', 'Órdenes de trabajo, historial por patente, stock de repuestos y presupuestos por WhatsApp. Conocé cómo IntegraTaller ordena tu taller.')

@php
    $modules = [
        ['icon' => 'calendar', 'label' => 'Turnos y clientes', 'text' => 'La agenda del taller y los datos de cada cliente, sin turnos pisados.', 'detail' => 'control-de-turnos'],
        ['icon' => 'car', 'label' => 'Historial por patente', 'text' => 'Buscá la patente y mirá qué se le hizo al auto, con qué repuestos y cuándo.', 'detail' => 'historial-por-patente'],
        ['icon' => 'package', 'label' => 'Stock de repuestos', 'text' => 'Repuestos, aceite y filtros a la vista, con aviso cuando queda poco.', 'detail' => 'control-de-stock'],
        ['icon' => 'send', 'label' => 'Presupuestos por WhatsApp', 'text' => 'Armá el presupuesto con tus costos y mandalo al cliente para que lo apruebe.', 'detail' => 'presupuestos-por-whatsapp'],
    ];
@endphp

@section('content')
    <x-page-header eyebrow="Funciones" title="Todo el trabajo del taller, en un solo sistema." subtitle="Turnos, vehículos, órdenes y repuestos conectados con el día a día de tu equipo.">
        <a href="{{ route('contacto') }}" class="boton boton-principal mt-8" data-cta="demo">Pedí tu demo</a>
    </x-page-header>

    <section class="seccion bg-white">
        <div class="contenedor grid gap-6 md:grid-cols-2">
            @foreach ($modules as $module)
                <article class="flex flex-col rounded-lg border border-borde p-6 sm:p-8">
                    <x-icon :name="$module['icon']" class="h-8 w-8 text-celeste-500" />
                    <h2 class="t-titulo-3 mt-4">{{ $module['label'] }}</h2>
                    <p class="mt-2 flex-1 text-texto-secundario">{{ $module['text'] }}</p>
                    <a href="{{ route('features.show', $module['detail']) }}" class="boton boton-terciario mt-5 self-start !px-0">
                        Ver detalle
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </article>
            @endforeach
        </div>
    </section>

    <section class="seccion bg-gris-50">
        <div class="contenedor grid gap-8 md:grid-cols-2 md:items-center md:gap-16">
            <x-section-heading eyebrow="Una guía por mes" title="Ideas para ordenar el taller." subtitle="Te llega un email por mes con guías prácticas y novedades." />
            <div class="tarjeta">
                @include('partials.newsletter-form', ['source' => 'servicios'])
            </div>
        </div>
    </section>

    <x-cierre title="Mirá cómo funciona en tu taller." />
@endsection

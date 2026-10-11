@extends('layouts.app')

@section('title', 'Funciones para organizar un taller mecánico | IntegraTaller')
@section('meta_description', 'Conocé cómo IntegraTaller ayuda a organizar turnos, órdenes de trabajo, vehículos, stock y presupuestos del taller.')

@php
    $modules = [
        ['slug' => 'control-de-turnos', 'label' => 'Turnos y clientes', 'text' => 'Reuní la agenda del taller y el historial de cada vehículo para consultar qué se hizo antes y qué trabajo sigue.', 'detail' => 'control-de-turnos'],
        ['slug' => 'historial-por-patente', 'label' => 'Historial por vehículo', 'text' => 'Buscá las reparaciones previas, los repuestos utilizados y los diagnósticos asociados al vehículo.', 'detail' => 'historial-por-patente'],
        ['slug' => 'control-de-stock', 'label' => 'Stock de repuestos', 'text' => 'Registrá repuestos, aceite y filtros, y consultá lo disponible para el trabajo del taller.', 'detail' => 'control-de-stock'],
        ['slug' => 'presupuestos-por-whatsapp', 'label' => 'Presupuestos', 'text' => 'Prepará cotizaciones con tus costos y compartilas con el cliente por WhatsApp.', 'detail' => 'presupuestos-por-whatsapp'],
    ];
@endphp

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <p class="section-kicker">Funciones</p>
            <h1 class="display-title mt-5 max-w-[12ch]">El trabajo del taller, ordenado en un mismo lugar.</h1>
            <p class="mt-6 max-w-[58ch] text-lg leading-relaxed text-secondary/75">Turnos, vehículos, órdenes y repuestos conectados con la operación diaria de tu equipo.</p>
            <a href="{{ route('contacto') }}" class="btn btn-primary mt-8" data-cta="demo">Solicitar una demo</a>
        </div>
    </section>

    <section class="bg-white">
        <div class="container-page section-gap">
            <div class="border-t-2 border-secondary">
                @foreach ($modules as $module)
                    <article class="grid gap-5 border-b border-line py-7 sm:grid-cols-[minmax(10rem,0.55fr)_1fr_auto] sm:items-center sm:gap-8 sm:py-9">
                        <div>
                            <h2 class="font-display text-3xl font-semibold sm:text-4xl">{{ $module['label'] }}</h2>
                        </div>
                        <p class="max-w-[55ch] leading-relaxed text-secondary/75">{{ $module['text'] }}</p>
                        <a href="{{ route('features.show', $module['detail']) }}" class="font-bold text-primary underline decoration-primary/30 underline-offset-4 hover:decoration-primary">Ver detalle</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-y border-line bg-neutral">
        <div class="container-page grid gap-8 py-12 sm:grid-cols-[1fr_auto] sm:items-center sm:py-14">
            <div>
                <p class="section-kicker">Para tu equipo</p>
                <h2 class="mt-4 max-w-[18ch] font-display text-4xl font-semibold leading-none sm:text-5xl">Una vista compartida del trabajo pendiente.</h2>
                <p class="mt-4 max-w-[58ch] leading-relaxed text-secondary/75">En la demo podés recorrer cómo se relacionan los módulos y conversar sobre las necesidades de tu taller.</p>
            </div>
            <a href="{{ route('contacto') }}" class="btn btn-primary" data-cta="demo">Verlo en una demo</a>
        </div>
    </section>

    <section class="bg-white">
        <div class="container-page grid gap-10 py-12 md:grid-cols-2 md:items-center md:py-16">
            <div>
                <p class="section-kicker">Una consulta al mes</p>
                <h2 class="mt-4 font-display text-4xl font-semibold leading-none sm:text-5xl">Ideas para hacer más claro el trabajo.</h2>
            </div>
            <div>
                @include('partials.newsletter-form', ['source' => 'servicios'])
            </div>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('title', 'IntegraTaller | Órdenes claras para talleres mecánicos')
@section('meta_description', 'Organizá turnos, órdenes de trabajo, stock y presupuestos de tu taller desde un solo lugar. Conocé IntegraTaller en una demo.')

@php
    $features = [
        ['name' => 'Órdenes de trabajo', 'text' => 'Registrá tareas, repuestos y el estado de cada vehículo.'],
        ['name' => 'Turnos y clientes', 'text' => 'Tené la agenda y el historial de cada vehículo a mano.'],
        ['name' => 'Stock de repuestos', 'text' => 'Mantené visibles las piezas y sus niveles disponibles.'],
        ['name' => 'Presupuestos', 'text' => 'Prepará una cotización y compartila con tu cliente por WhatsApp.'],
    ];

    $faqs = [
        ['q' => '¿Qué voy a ver en la demo?', 'a' => 'Vas a poder conocer cómo se organizan las órdenes, los vehículos y los módulos del sistema para entender si se adaptan al trabajo de tu taller.'],
        ['q' => '¿Tengo que instalar el sistema?', 'a' => 'IntegraTaller funciona en la nube. Podés acceder desde un dispositivo con conexión a internet.'],
        ['q' => '¿Cómo se calcula el precio?', 'a' => 'El valor depende del tamaño y las necesidades del taller. En la demo podemos orientarte sobre las opciones disponibles.', 'cotizer' => true],
        ['q' => '¿Puedo recibir consejos aunque todavía no quiera una demo?', 'a' => 'Sí. Suscribite para recibir guías prácticas y novedades de IntegraTaller una vez al mes. Te vamos a pedir que confirmes tu email y podés darte de baja cuando quieras.'],
    ];
@endphp

@section('content')
    <section class="overflow-hidden border-b border-line bg-neutral">
        <div class="container-page grid items-center gap-12 py-14 sm:py-20 lg:min-h-[42rem] lg:grid-cols-[1.02fr_0.98fr] lg:gap-10 lg:py-16">
            <div class="max-w-2xl">
                <p class="section-kicker">Gestión para talleres mecánicos</p>
                <h1 class="display-title mt-5 max-w-[13ch]">Todas las órdenes del taller, a la vista.</h1>
                <p class="mt-6 max-w-[54ch] text-lg leading-relaxed text-secondary/75 sm:text-xl">
                    Coordiná turnos, órdenes, stock y presupuestos desde un solo lugar. Menos tiempo buscando datos; más claridad para organizar el trabajo.
                </p>
                <div class="mt-8 flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                    <a href="{{ route('contacto') }}" class="btn btn-primary w-full sm:w-auto" data-cta="demo">Solicitar una demo</a>
                    <a href="{{ route('servicios') }}" class="font-bold text-primary underline decoration-primary/30 underline-offset-4 hover:decoration-primary">Conocer las funciones</a>
                </div>
                <p class="mt-4 text-sm text-secondary/65">Coordinamos un recorrido según el trabajo de tu taller.</p>
            </div>

            <div class="relative mx-auto w-full max-w-[34rem] lg:mr-0">
                <div class="relative rounded-sm bg-primary-deep p-5 text-white sm:p-7">
                    <div class="flex items-start justify-between gap-4 border-b border-white/20 pb-5">
                        <div>
                            <p class="font-mono text-xs text-white/65">RECORRIDO DE UNA ORDEN</p>
                            <h2 class="mt-2 font-display text-3xl font-semibold text-white sm:text-4xl">Del ingreso a la entrega</h2>
                        </div>
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-sm bg-accent text-secondary">
                            <x-icon name="clipboard" class="h-6 w-6" />
                        </span>
                    </div>

                    <div class="work-order mt-5 space-y-3 rounded-sm bg-white px-5 py-5 text-secondary sm:px-7">
                        @foreach ([['Diagnóstico', 'Registrá el trabajo pendiente', 'primary'], ['Presupuesto', 'Compartí el detalle con el cliente', 'accent'], ['En trabajo', 'Mantené las tareas a la vista', 'surface'], ['Listo para retirar', 'Consultá el estado de la orden', 'secondary']] as [$stage, $description, $tone])
                            <div class="relative flex items-start gap-3 border-b border-line/80 pb-3 last:border-0 last:pb-0">
                                <span class="status-dot mt-1 {{ $tone === 'primary' ? 'text-primary' : ($tone === 'accent' ? 'text-accent' : ($tone === 'surface' ? 'text-surface' : 'text-secondary/50')) }}"></span>
                                <div>
                                    <p class="font-display text-xl font-semibold leading-none">{{ $stage }}</p>
                                    <p class="mt-1 text-sm text-secondary/70">{{ $description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <p class="mt-4 text-xs leading-relaxed text-white/65">Un ejemplo del recorrido de trabajo, no una captura de la aplicación.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-line bg-white" aria-labelledby="clientes-title">
        <div class="container-page grid gap-8 py-12 md:grid-cols-[0.8fr_1.2fr] md:items-center md:gap-14 md:py-14">
            <div>
                <p class="section-kicker">En la operación</p>
                <h2 id="clientes-title" class="mt-4 font-display text-4xl font-semibold leading-none sm:text-5xl">Talleres que ya usan IntegraTaller.</h2>
                <p class="mt-4 max-w-[44ch] leading-relaxed text-secondary/70">Dos equipos del sector automotor organizan su trabajo con el sistema.</p>
            </div>

            <div class="grid gap-px border-y border-line bg-line sm:grid-cols-2">
                <article class="bg-neutral p-5 sm:p-6">
                    <div class="flex h-28 items-center justify-center bg-white p-2 sm:h-32">
                        <img src="{{ asset('logo sciaca.jpg') }}" alt="Logo de Taller Sciaca" width="480" height="480" loading="lazy" decoding="async" class="h-full max-w-full object-contain">
                    </div>
                    <h3 class="mt-4 font-display text-2xl font-semibold">Taller Sciaca</h3>
                    <p class="mt-1 text-sm text-secondary/70">Servicios para automotores</p>
                </article>

                <article class="bg-neutral p-5 sm:p-6">
                    <div class="flex h-28 items-center justify-center bg-white p-3 sm:h-32">
                        <img src="{{ asset('logo mistage.png') }}" alt="Logo de Mistage" width="2000" height="1000" loading="lazy" decoding="async" class="h-full max-w-full object-contain">
                    </div>
                    <h3 class="mt-4 font-display text-2xl font-semibold">Mistage</h3>
                    <p class="mt-1 text-sm text-secondary/70">Recupero de siniestros</p>
                </article>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="container-page section-gap">
            <div class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:gap-20">
                <div>
                    <p class="section-kicker">El día a día, más claro</p>
                    <h2 class="section-title mt-5 max-w-[10ch]">Encontrá lo que necesitás sin frenar el trabajo.</h2>
                    <p class="mt-5 max-w-[48ch] leading-relaxed text-secondary/75">Cuando la información queda repartida entre papeles y conversaciones, cuesta saber qué sigue. IntegraTaller reúne las tareas y los datos del vehículo en una misma gestión.</p>
                    <a href="{{ route('contacto') }}" class="mt-7 inline-flex font-bold text-primary underline decoration-primary/30 underline-offset-4 hover:decoration-primary" data-cta="demo">Verlo en una demo</a>
                </div>

                <div class="border-t-2 border-secondary">
                    @foreach ($features as $feature)
                        <article class="border-b border-line py-5 sm:py-6">
                            <div>
                                <h3 class="font-display text-2xl font-semibold sm:text-3xl">{{ $feature['name'] }}</h3>
                                <p class="mt-2 max-w-[58ch] text-secondary/70">{{ $feature['text'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="como-funciona" class="border-y border-line bg-neutral">
        <div class="container-page section-gap">
            <div class="max-w-2xl">
                <p class="section-kicker">Así empieza</p>
                <h2 class="section-title mt-5">Primero conocemos cómo trabaja tu taller.</h2>
                <p class="mt-4 max-w-[55ch] leading-relaxed text-secondary/75">La demo sirve para recorrer el sistema con tus necesidades en mente y conversar sobre los siguientes pasos.</p>
            </div>
            <ol class="mt-12 grid gap-0 border-t-2 border-secondary md:grid-cols-3">
                @foreach ([['Contanos', 'Decinos qué tipo de taller tenés y qué querés ordenar.'], ['Recorré el sistema', 'Te mostramos los módulos relevantes para tu operación.'], ['Evaluá opciones', 'Conversamos sobre el tamaño del equipo y el plan que puede servirte.']] as [$title, $description])
                    <li class="border-b border-line py-6 md:border-b-0 md:border-r md:px-6 md:py-7 md:first:pl-0 md:last:border-r-0">
                        <span class="font-mono text-sm text-primary">PASO {{ $loop->iteration }}</span>
                        <h3 class="mt-3 font-display text-3xl font-semibold">{{ $title }}</h3>
                        <p class="mt-2 max-w-[38ch] text-secondary/70">{{ $description }}</p>
                    </li>
                @endforeach
            </ol>
            <a href="{{ route('contacto') }}" class="btn btn-primary mt-8" data-cta="demo">Solicitar una demo</a>
        </div>
    </section>

    <section class="bg-primary-deep text-white" aria-labelledby="newsletter-home-title">
        <div class="container-page grid gap-8 py-12 md:grid-cols-[1fr_1fr] md:items-center md:gap-16 md:py-16">
            <div>
                <p class="section-kicker !text-white before:!bg-accent">Para leer entre trabajos</p>
                <h2 id="newsletter-home-title" class="mt-4 font-display text-4xl font-semibold leading-none text-white sm:text-5xl">Una guía práctica, una vez al mes.</h2>
                <p class="mt-4 max-w-[52ch] leading-relaxed text-white/75">Ideas para ordenar turnos, órdenes y stock, más novedades de IntegraTaller. Sin llenar tu bandeja.</p>
            </div>
            <div class="rounded-sm bg-white p-5 text-secondary sm:p-7">
                @include('partials.newsletter-form', ['source' => 'home'])
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="container-page section-gap">
            <div class="max-w-2xl">
                <p class="section-kicker">Dudas frecuentes</p>
                <h2 class="section-title mt-5">Antes de ver el sistema.</h2>
            </div>
            <div class="mt-9 max-w-4xl border-t-2 border-secondary">
                @foreach ($faqs as $faq)
                    <details class="border-b border-line py-5">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-6 font-display text-2xl font-semibold marker:content-none sm:text-3xl">
                            {{ $faq['q'] }}
                            <x-icon name="chevron-down" class="h-5 w-5 shrink-0 text-primary" />
                        </summary>
                        <p class="mt-4 max-w-[70ch] leading-relaxed text-secondary/75">
                            {{ $faq['a'] }}
                            @if (!empty($faq['cotizer']))
                                <a href="{{ config('landing.app_url') }}" class="font-bold text-primary underline decoration-primary/30 underline-offset-4 hover:decoration-primary">También podés consultar el cotizador.</a>
                            @endif
                        </p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-t border-white/20 bg-primary py-14 text-white sm:py-16">
        <div class="container-page flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div class="max-w-2xl">
                <p class="section-kicker !text-white before:!bg-accent">Conocé IntegraTaller</p>
                <h2 class="mt-4 font-display text-5xl font-semibold leading-none text-white sm:text-6xl">Veamos cómo encaja en tu taller.</h2>
            </div>
            <a href="{{ route('contacto') }}" class="btn btn-light shrink-0" data-cta="demo">Solicitar una demo</a>
        </div>
    </section>
@endsection

@push('head')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => 'IntegraTaller',
            'applicationCategory' => 'BusinessApplication',
            'operatingSystem' => 'Web',
            'url' => url('/'),
            'inLanguage' => 'es-AR',
            'description' => 'Software para organizar turnos, órdenes de trabajo, vehículos, stock y presupuestos de talleres mecánicos.',
            'areaServed' => ['@type' => 'Country', 'name' => 'Argentina'],
            'featureList' => collect($features)->pluck('name')->all(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($faqs)->map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
            ])->all(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

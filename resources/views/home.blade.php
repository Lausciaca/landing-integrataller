@extends('layouts.app')

@section('title', 'IntegraTaller | Tu taller, en orden.')
@section('meta_description', 'Órdenes de trabajo, clientes y finanzas de todas tus sucursales en un solo sistema. Para talleres mecánicos y de estética vehicular. Pedí tu demo.')

@php
    $questions = [
        ['q' => '¿En qué quedó la Hilux que entró el lunes?', 'today' => 'Hoy: preguntás en el taller.'],
        ['q' => '¿Por qué no cierra la caja de Norte?', 'today' => 'Hoy: revisás planillas.'],
        ['q' => '¿Cuánto facturamos este mes entre todas las sedes?', 'today' => 'Hoy: sumás a mano.'],
        ['q' => '¿Quién hizo ese trabajo?', 'today' => 'Hoy: buscás en el chat.'],
    ];

    $audiences = [
        ['icon' => 'wrench', 'label' => 'Talleres mecánicos'],
        ['icon' => 'droplets', 'label' => 'Estética vehicular'],
        ['icon' => 'store', 'label' => 'Varias sucursales'],
        ['icon' => 'users', 'label' => 'Equipos de 4 personas o más'],
    ];

    $journey = [
        ['icon' => 'car', 'title' => 'Ingresa el vehículo', 'text' => 'Patente, cliente y lo que pide. Queda abierta la orden.', 'status' => 'Ingresado', 'tone' => 'neutro'],
        ['icon' => 'search', 'title' => 'Diagnóstico y presupuesto', 'text' => 'Tareas, repuestos y mano de obra, listos para que el cliente apruebe.', 'status' => 'Esperando aprobación', 'tone' => 'alerta'],
        ['icon' => 'wrench', 'title' => 'Manos a la obra', 'text' => 'Cada tarea con su responsable. Ves el avance sin ir al taller.', 'status' => 'En proceso', 'tone' => 'info'],
        ['icon' => 'check', 'title' => 'Listo para retirar', 'text' => 'El trabajo terminado queda marcado y el cliente sabe que puede pasar.', 'status' => 'Listo', 'tone' => 'exito'],
        ['icon' => 'wallet', 'title' => 'Entregado y cobrado', 'text' => 'El cobro entra a la caja de la sucursal y la orden se cierra.', 'status' => 'Cerrado', 'tone' => 'cerrado'],
    ];

    $features = [
        'sucursales' => ['icon' => 'store', 'name' => 'Varias sucursales', 'text' => 'Todas tus sedes en un mismo sistema, con la información separada y comparable. Mirá una por una o todas juntas.'],
        'ordenes' => ['icon' => 'clipboard', 'name' => 'Órdenes de trabajo', 'text' => 'Cada trabajo con sus tareas, repuestos, responsable y estado, desde el ingreso hasta la entrega.'],
        'clientes' => ['icon' => 'car', 'name' => 'Clientes y vehículos', 'text' => 'El historial de cada auto por patente y los datos del cliente a mano.'],
        'caja' => ['icon' => 'wallet', 'name' => 'Caja y finanzas', 'text' => 'Cobros, pagos y deudas de cada sucursal. Sabé cuánto facturaste hoy.'],
        'reportes' => ['icon' => 'bar-chart', 'name' => 'Reportes', 'text' => 'Facturación, órdenes y trabajos por sucursal, por período y por persona.'],
        'equipo' => ['icon' => 'users', 'name' => 'Equipo y permisos', 'text' => 'Cada persona ve y hace lo que le corresponde: dueño, encargado o recepción.'],
    ];

    $steps = [
        ['title' => 'Pedí tu demo', 'text' => 'Contanos cómo trabaja tu taller y te mostramos el sistema con tus necesidades en mente.'],
        ['title' => 'Cargamos tus datos con vos', 'text' => 'Te acompañamos a cargar sucursales, equipo, clientes y servicios.'],
        ['title' => 'Tu equipo empieza a trabajar', 'text' => 'Cada persona entra con su usuario y las órdenes empiezan a quedar registradas.'],
    ];

    $faqs = [
        ['q' => '¿Qué voy a ver en la demo?', 'a' => 'Un recorrido por órdenes de trabajo, clientes, caja y sucursales, pensado según cómo trabaja tu taller.'],
        ['q' => '¿Sirve para talleres de estética vehicular?', 'a' => 'Sí. IntegraTaller sirve para talleres mecánicos y para lavado, detailing, pintura, polarizado y ploteo.'],
        ['q' => '¿Tengo que instalar algo?', 'a' => 'No. Funciona en la nube: entrás desde la computadora, la tablet o el celular, desde cualquier lugar.'],
        ['q' => '¿Puedo usarlo con varias sucursales?', 'a' => 'Sí. Cada sucursal tiene su información, y vos podés ver todas juntas o una por una.'],
        ['q' => '¿Cuánto cuesta?', 'a' => 'Depende de la cantidad de sucursales y personas. En la demo te pasamos el precio exacto para tu taller.', 'cotizer' => true],
        ['q' => '¿Puedo recibir consejos aunque todavía no quiera una demo?', 'a' => 'Sí. Suscribite a la guía mensual al pie de esta página: confirmás tu email y te das de baja cuando quieras.'],
    ];
@endphp

@section('content')
    {{-- Portada --}}
    <section class="overflow-hidden bg-azul-800 text-white">
        <div class="contenedor grid items-center gap-10 py-16 md:py-20 lg:grid-cols-[1fr_1.1fr] lg:gap-12 lg:py-28">
            <div>
                <p class="t-etiqueta !text-celeste-400">Sistema de gestión para talleres</p>
                <h1 class="t-display mt-5 !text-white">Tu taller, en orden.</h1>
                <p class="t-cuerpo-grande mt-6 max-w-[32rem] text-azul-100">
                    Órdenes de trabajo, clientes y finanzas de todas tus sucursales en un solo sistema. Sabé qué pasa en cada taller, sin estar ahí.
                </p>
                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('contacto') }}" class="boton boton-claro" data-cta="demo">Pedí tu demo</a>
                    <a href="#como-funciona" class="boton boton-borde-claro">Ver cómo funciona</a>
                </div>
                <p class="t-cuerpo-chico mt-10 text-azul-100">Para talleres mecánicos y de estética vehicular. Hecho en Argentina.</p>
            </div>

            <x-nodos animado
                     class="mx-auto w-full max-w-[600px]"
                     style="--nodos-base: var(--color-blanco); --nodos-acento: var(--color-celeste-400)"
                     :etiquetas="[['Sucursal Centro', 'Órdenes al día'], ['Sucursal Norte', 'Caja al día'], ['Sucursal Sur', 'Equipo en marcha']]" />
        </div>
    </section>

    {{-- Las preguntas del dueño --}}
    <section class="seccion bg-white" aria-labelledby="preguntas-dueno-title">
        <div class="contenedor">
            <p class="t-etiqueta">El día a día</p>
            <h2 id="preguntas-dueno-title" class="t-titulo-1 mt-3 max-w-[680px]">Cuando el taller crece, las preguntas se repiten.</h2>

            <ul class="mt-12 border-t border-borde">
                @foreach ($questions as $question)
                    <li data-revelar class="grid gap-2 border-b border-borde py-6 md:grid-cols-[1fr_auto] md:items-baseline md:gap-10 md:py-8">
                        <p class="t-titulo-2 text-azul-800 md:!text-[34px] md:!leading-[42px]">{{ $question['q'] }}</p>
                        <p class="text-texto-secundario">{{ $question['today'] }}</p>
                    </li>
                @endforeach
            </ul>

            <div data-revelar class="mt-12 flex flex-col gap-6 rounded-xl bg-azul-50 p-8 md:flex-row md:items-center md:gap-10 md:p-12">
                <x-logo variant="isotipo" class="h-16 w-16 shrink-0" />
                <div>
                    <p class="t-titulo-2 text-azul-800">Con IntegraTaller, la respuesta está en un solo lugar.</p>
                    <p class="t-cuerpo-grande mt-2 text-texto-secundario">Sin llamar a nadie, sin cuadernos, desde el celular o la computadora.</p>
                </div>
            </div>

            <div class="mt-12 flex flex-col gap-4 md:flex-row md:items-center md:gap-8">
                <p class="t-etiqueta shrink-0 !text-texto-secundario">Hecho para</p>
                <ul class="flex flex-wrap gap-3">
                    @foreach ($audiences as $audience)
                        <li class="inline-flex items-center gap-2 rounded-full border border-borde px-4 py-2.5 font-medium text-azul-800">
                            <x-icon :name="$audience['icon']" class="h-5 w-5 text-celeste-700" />
                            {{ $audience['label'] }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- El recorrido de una orden --}}
    <section id="como-funciona" class="seccion bg-gris-50" aria-labelledby="recorrido-title">
        <div class="contenedor">
            <x-section-heading id="recorrido-title" eyebrow="Cómo funciona" title="Del ingreso al cobro, cada auto deja su rastro." subtitle="Así viaja una orden de trabajo en IntegraTaller. En cada paso sabés en qué está y quién se ocupa." />

            <div class="recorrido relative mt-14">
                <div class="absolute bottom-7 left-7 top-7 w-0.5 bg-gris-200 lg:hidden" aria-hidden="true">
                    <div class="recorrido-linea-progreso h-full w-full origin-top bg-azul-800"></div>
                </div>
                <div class="absolute left-7 right-[calc((100%_-_6rem)/5_-_28px)] top-7 hidden h-0.5 bg-gris-200 lg:block" aria-hidden="true">
                    <div class="recorrido-linea-progreso h-full w-full origin-left bg-azul-800"></div>
                </div>

                <ol class="relative grid gap-10 lg:grid-cols-5 lg:gap-6">
                @foreach ($journey as $step)
                    <li class="relative flex gap-5 lg:block">
                        <span class="recorrido-nodo relative z-10 inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-full" style="--i: {{ $loop->index }}">
                            <x-icon :name="$step['icon']" class="h-6 w-6" />
                        </span>
                        <div class="lg:mt-6">
                            <x-estado :tipo="$step['tone']">{{ $step['status'] }}</x-estado>
                            <h3 class="t-titulo-3 mt-3">{{ $step['title'] }}</h3>
                            <p class="mt-2 text-texto-secundario">{{ $step['text'] }}</p>
                        </div>
                    </li>
                @endforeach
                </ol>
            </div>
        </div>
    </section>

    {{-- Funciones --}}
    <section id="funciones" class="seccion bg-white" aria-labelledby="funciones-title">
        <div class="contenedor">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-section-heading id="funciones-title" eyebrow="Funciones" title="Órdenes, clientes y finanzas. Todo en un lugar." />
                <a href="{{ route('servicios') }}" class="boton boton-terciario shrink-0 self-start !px-0 md:self-auto">
                    Ver todas las funciones
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>

            <div class="mt-12 grid gap-5 lg:grid-cols-6">
                {{-- Sucursales: la idea central de la marca --}}
                <article data-revelar class="relative flex min-h-[380px] flex-col overflow-hidden rounded-xl bg-azul-800 p-8 text-white md:p-10 lg:col-span-3 lg:row-span-2">
                    <x-nodos class="pointer-events-none absolute -bottom-28 -right-24 hidden w-[420px] opacity-70 sm:block" style="--nodos-base: var(--color-azul-700)" />
                    <div class="relative max-w-[340px]">
                        <p class="t-etiqueta !text-celeste-400">{{ $features['sucursales']['name'] }}</p>
                        <h3 class="t-titulo-1 mt-4 !text-white">Todas tus sucursales, un solo sistema.</h3>
                        <p class="t-cuerpo-grande mt-4 text-azul-100">{{ $features['sucursales']['text'] }}</p>
                    </div>
                </article>

                <article data-revelar class="rounded-xl border border-borde p-8 lg:col-span-3">
                    <p class="t-etiqueta">{{ $features['ordenes']['name'] }}</p>
                    <h3 class="t-titulo-3 mt-3">Cada trabajo sabe en qué está.</h3>
                    <p class="mt-2 text-texto-secundario">{{ $features['ordenes']['text'] }}</p>
                    <div class="mt-6 flex flex-wrap gap-2" aria-hidden="true">
                        <x-estado tipo="neutro">Ingresado</x-estado>
                        <x-estado tipo="info">En proceso</x-estado>
                        <x-estado tipo="exito">Listo</x-estado>
                        <x-estado tipo="cerrado">Cerrado</x-estado>
                    </div>
                </article>

                <article data-revelar class="flex flex-col gap-6 rounded-xl border border-borde p-8 sm:flex-row sm:items-center sm:justify-between lg:col-span-3">
                    <div>
                        <p class="t-etiqueta">{{ $features['clientes']['name'] }}</p>
                        <h3 class="t-titulo-3 mt-3">La patente cuenta la historia.</h3>
                        <p class="mt-2 text-texto-secundario">{{ $features['clientes']['text'] }}</p>
                    </div>
                    <div class="patente shrink-0 self-start sm:self-center" aria-hidden="true">
                        <span class="patente-banda">Argentina</span>
                        <span class="patente-numero">AE 482 KD</span>
                    </div>
                </article>

                @foreach (['caja', 'reportes', 'equipo'] as $key)
                    <article data-revelar class="rounded-xl bg-gris-50 p-8 lg:col-span-2">
                        <x-icon :name="$features[$key]['icon']" class="h-8 w-8 text-celeste-700" />
                        <h3 class="t-titulo-3 mt-5">{{ $features[$key]['name'] }}</h3>
                        <p class="mt-2 text-texto-secundario">{{ $features[$key]['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Talleres que confían --}}
    <section id="clientes" class="border-y border-borde bg-gris-50 py-14 md:py-16" aria-labelledby="clientes-title">
        <div class="contenedor flex flex-col gap-10 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="t-etiqueta">Talleres que confían</p>
                <h2 id="clientes-title" class="t-titulo-2 mt-3">Ya trabajan con IntegraTaller.</h2>
            </div>
            <ul class="flex flex-wrap items-center gap-x-14 gap-y-8">
                <li class="flex items-center gap-4">
                    <img src="{{ asset('logo sciaca.jpg') }}" alt="Logo de Taller Sciaca" width="480" height="480" loading="lazy" decoding="async" class="h-20 w-20 rounded-md object-contain">
                    <div>
                        <p class="font-bold text-azul-800">Taller Sciaca</p>
                        <p class="t-cuerpo-chico text-texto-secundario">Servicios para automotores</p>
                    </div>
                </li>
                <li class="flex items-center gap-4">
                    <img src="{{ asset('logo mistage.png') }}" alt="Logo de Mistage" width="2000" height="1000" loading="lazy" decoding="async" class="h-20 w-40 object-contain">
                    <div>
                        <p class="font-bold text-azul-800">Mistage</p>
                        <p class="t-cuerpo-chico text-texto-secundario">Recupero de siniestros</p>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    {{-- Cómo empezar --}}
    <section id="como-empezar" class="seccion bg-white" aria-labelledby="empezar-title">
        <div class="contenedor">
            <x-section-heading id="empezar-title" eyebrow="Cómo empezar" title="Tres pasos y tu equipo ya está trabajando." />
            <ol class="mt-12 grid gap-10 md:grid-cols-3 md:gap-8">
                @foreach ($steps as $step)
                    <li data-revelar>
                        <div class="flex items-center gap-4" aria-hidden="true">
                            <span class="h-4 w-4 shrink-0 rounded-full bg-celeste-500"></span>
                            @unless ($loop->last)
                                <span class="hidden h-0.5 flex-1 bg-gris-200 md:block"></span>
                            @endunless
                        </div>
                        <p class="t-display mt-6 text-celeste-700">0{{ $loop->iteration }}</p>
                        <h3 class="t-titulo-3 mt-3">{{ $step['title'] }}</h3>
                        <p class="mt-2 max-w-[34ch] text-texto-secundario">{{ $step['text'] }}</p>
                    </li>
                @endforeach
            </ol>
            <a href="{{ route('contacto') }}" class="boton boton-principal mt-12" data-cta="demo">Pedí tu demo</a>
        </div>
    </section>

    {{-- Preguntas frecuentes --}}
    <section id="preguntas" class="seccion bg-gris-50" aria-labelledby="faq-title">
        <div class="contenedor grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:gap-16">
            <div>
                <x-section-heading id="faq-title" eyebrow="Preguntas frecuentes" title="Antes de ver el sistema." />
                <a href="{{ config('landing.app_url') }}" class="boton boton-secundario mt-8">Calcular mi plan</a>
            </div>
            <div class="space-y-3">
                @foreach ($faqs as $faq)
                    <details class="pregunta rounded-lg bg-white shadow-1">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-6 p-5 font-medium text-azul-800 sm:p-6">
                            {{ $faq['q'] }}
                            <x-icon name="chevron-down" class="pregunta-icono h-5 w-5 shrink-0 text-celeste-700" />
                        </summary>
                        <p class="max-w-[62ch] px-5 pb-5 text-texto-secundario sm:px-6 sm:pb-6">
                            {{ $faq['a'] }}
                            @if (!empty($faq['cotizer']))
                                <a href="{{ config('landing.app_url') }}" class="enlace">También podés usar el cotizador.</a>
                            @endif
                        </p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Cierre --}}
    <section class="relative overflow-hidden bg-azul-800 text-white" aria-labelledby="cierre-title">
        <x-nodos class="pointer-events-none absolute -right-20 top-1/2 hidden w-[460px] -translate-y-1/2 md:block" style="--nodos-base: var(--color-azul-700)" />
        <div class="contenedor relative py-16 md:py-24">
            <p class="t-etiqueta !text-celeste-400">IntegraTaller</p>
            <h2 id="cierre-title" class="t-display mt-4 !text-white">Tu taller, en orden.</h2>
            <p class="t-cuerpo-grande mt-4 max-w-[36rem] text-azul-100">Todas tus sucursales, un solo sistema. Te mostramos cómo funciona con el trabajo de tu taller.</p>
            <a href="{{ route('contacto') }}" class="boton boton-claro mt-8" data-cta="demo">Pedí tu demo</a>
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
            'description' => 'Sistema de gestión para talleres mecánicos y de estética vehicular: órdenes de trabajo, clientes y finanzas de todas las sucursales en un solo lugar.',
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

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

    // Un caso concreto: la Hilux que entra a la sucursal Norte el lunes y se va cobrada el martes
    $journey = [
        ['icon' => 'car', 'when' => 'Lun 08:40', 'title' => 'Ingresa el vehículo', 'text' => 'Entra por ruido al frenar. Recepción abre la orden.', 'status' => 'Ingresado', 'tone' => 'neutro'],
        ['icon' => 'search', 'when' => 'Lun 10:15', 'title' => 'Diagnóstico y presupuesto', 'text' => 'Pastillas y discos: el presupuesto le llega al cliente.', 'status' => 'Esperando aprobación', 'tone' => 'alerta'],
        ['icon' => 'wrench', 'when' => 'Lun 12:30', 'title' => 'Manos a la obra', 'text' => 'El cliente aprueba y Martín toma el trabajo.', 'status' => 'En proceso', 'tone' => 'info'],
        ['icon' => 'check', 'when' => 'Mar 16:00', 'title' => 'Listo para retirar', 'text' => 'Trabajo probado. El cliente sabe que puede pasar.', 'status' => 'Listo', 'tone' => 'exito'],
        ['icon' => 'wallet', 'when' => 'Mar 18:20', 'title' => 'Entregado y cobrado', 'text' => 'El cobro entra a la caja de Norte y la orden se cierra.', 'status' => 'Cerrado', 'tone' => 'cerrado'],
    ];

    $testimonial = [
        'quote' => 'Antes, para saber en qué estaba cada auto había que preguntar en el taller. Ahora lo veo en el celular antes de llegar.',
        'author' => 'Taller Sciaca',
        'role' => 'Servicios para automotores',
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
        <div class="contenedor grid items-center gap-8 pb-12 pt-12 md:gap-10 md:py-20 lg:grid-cols-[1fr_1.1fr] lg:gap-12 lg:py-28">
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
                <p class="t-cuerpo-chico mt-8 text-azul-100 md:mt-10">Para talleres mecánicos y de estética vehicular. Hecho en Argentina.</p>
            </div>

            <x-nodos animado
                     class="mx-auto w-full max-w-[600px] pr-5 sm:px-6 lg:px-0"
                     style="--nodos-base: var(--color-blanco); --nodos-acento: var(--color-celeste-400)"
                     :etiquetas="[['Sucursal Centro', 'Órdenes al día'], ['Sucursal Norte', 'Caja al día'], ['Sucursal Sur', 'Equipo en marcha']]" />
        </div>
    </section>

    {{-- Las preguntas del dueño --}}
    <section class="seccion bg-white" aria-labelledby="preguntas-dueno-title">
        <div class="contenedor">
            <p class="t-etiqueta">El día a día</p>
            <h2 id="preguntas-dueno-title" class="t-titulo-1 mt-3 max-w-[680px]">Cuando el taller crece, las preguntas se repiten.</h2>

            <ul class="mt-8 border-t border-borde md:mt-12">
                @foreach ($questions as $question)
                    <li data-revelar class="grid gap-2 border-b border-borde py-6 md:grid-cols-[1fr_auto] md:items-baseline md:gap-10 md:py-8">
                        <p class="t-titulo-2 text-azul-800 md:!text-[34px] md:!leading-[42px]">{{ $question['q'] }}</p>
                        <p class="text-texto-secundario">{{ $question['today'] }}</p>
                    </li>
                @endforeach
            </ul>

            <div data-revelar class="mt-10 flex flex-col gap-5 rounded-xl bg-azul-50 p-6 sm:p-8 md:mt-12 md:flex-row md:items-center md:gap-10 md:p-12">
                <x-logo variant="isotipo" class="h-12 w-12 shrink-0 md:h-16 md:w-16" />
                <div>
                    <p class="t-titulo-2 text-azul-800">Con IntegraTaller, la respuesta está en un solo lugar.</p>
                    <p class="t-cuerpo-grande mt-2 text-texto-secundario">Sin llamar a nadie, sin cuadernos, desde el celular o la computadora.</p>
                </div>
            </div>

            <p class="mt-8 text-texto-secundario">
                Hecho para talleres mecánicos y de estética vehicular, con una o varias sucursales y equipos de 4 personas o más.
            </p>
        </div>
    </section>

    {{-- El recorrido de una orden --}}
    <section id="como-funciona" class="seccion bg-gris-50" aria-labelledby="recorrido-title">
        <div class="contenedor">
            <div class="mx-auto flex max-w-[720px] flex-col items-center text-center">
                <p class="t-etiqueta">Cómo funciona</p>
                <div class="patente mt-5" aria-hidden="true">
                    <span class="patente-banda">Argentina</span>
                    <span class="patente-numero">AE 482 KD</span>
                </div>
                <h2 id="recorrido-title" class="t-titulo-1 mt-6">Lunes 8:40 entró. Martes 18:20 se fue cobrada.</h2>
                <p class="t-cuerpo-grande mt-4 text-texto-secundario">En el medio, todo quedó registrado: quién la atendió, qué se aprobó y cuánto se cobró.</p>
            </div>

            <div class="recorrido relative mx-auto mt-12 max-w-[920px] md:mt-16">
                <div class="absolute bottom-7 left-7 top-7 w-0.5 -translate-x-1/2 bg-gris-200 lg:left-1/2" aria-hidden="true">
                    <div class="recorrido-linea-progreso h-full w-full origin-top bg-azul-800"></div>
                </div>

                <ol class="relative grid gap-10 lg:gap-6">
                @foreach ($journey as $step)
                    <li class="relative flex gap-5 lg:grid lg:grid-cols-[1fr_3.5rem_1fr] lg:items-start lg:gap-8">
                        <span class="recorrido-nodo relative z-10 inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-full lg:col-start-2 lg:row-start-1" style="--i: {{ $loop->index }}">
                            <x-icon :name="$step['icon']" class="h-6 w-6" />
                        </span>
                        <div @class([
                            'pt-1 lg:row-start-1 lg:pt-2',
                            'lg:col-start-1 lg:text-right' => $loop->odd,
                            'lg:col-start-3' => $loop->even,
                        ])>
                            <p class="font-medium tabular-nums text-celeste-700">{{ $step['when'] }}</p>
                            <h3 class="t-titulo-3 mt-1">{{ $step['title'] }}</h3>
                            <p class="mt-1 text-texto-secundario">{{ $step['text'] }}</p>
                            <x-estado :tipo="$step['tone']" class="mt-3">{{ $step['status'] }}</x-estado>
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

            <div class="mt-10 grid gap-4 md:mt-12 md:grid-cols-2 md:gap-5 lg:grid-cols-6">
                {{-- Sucursales: la idea central de la marca --}}
                <article data-revelar class="relative flex flex-col overflow-hidden rounded-xl bg-azul-800 p-6 pb-52 text-white sm:p-8 sm:pb-8 md:col-span-2 md:min-h-[380px] md:p-10 lg:col-span-3 lg:row-span-2">
                    <x-nodos class="pointer-events-none absolute -bottom-24 -right-16 w-[300px] opacity-70 sm:-bottom-28 sm:-right-24 sm:w-[420px]" style="--nodos-base: var(--color-azul-700)" />
                    <div class="relative max-w-[340px]">
                        <p class="t-etiqueta !text-celeste-400">{{ $features['sucursales']['name'] }}</p>
                        <h3 class="t-titulo-1 mt-4 !text-white">Todas tus sucursales, un solo sistema.</h3>
                        <p class="t-cuerpo-grande mt-4 text-azul-100">{{ $features['sucursales']['text'] }}</p>
                    </div>
                </article>

                <article data-revelar class="rounded-xl border border-borde p-6 sm:p-8 lg:col-span-3">
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

                <article data-revelar class="flex flex-col gap-6 rounded-xl border border-borde p-6 sm:flex-row sm:items-center sm:justify-between sm:p-8 md:flex-col md:items-start lg:col-span-3 lg:flex-row lg:items-center">
                    <div>
                        <p class="t-etiqueta">{{ $features['clientes']['name'] }}</p>
                        <h3 class="t-titulo-3 mt-3">La patente cuenta la historia.</h3>
                        <p class="mt-2 text-texto-secundario">{{ $features['clientes']['text'] }}</p>
                    </div>
                    <div class="patente shrink-0 self-start sm:self-center md:self-start lg:self-center" aria-hidden="true">
                        <span class="patente-banda">Argentina</span>
                        <span class="patente-numero">AE 482 KD</span>
                    </div>
                </article>

                @foreach (['caja', 'reportes', 'equipo'] as $key)
                    <article data-revelar @class([
                        'flex gap-4 rounded-xl bg-gris-50 p-6 sm:block sm:p-8 lg:col-span-2',
                        'md:col-span-2' => $loop->last,
                    ])>
                        <x-icon :name="$features[$key]['icon']" class="h-7 w-7 shrink-0 text-celeste-700 sm:h-8 sm:w-8" />
                        <div>
                            <h3 class="t-titulo-3 sm:mt-5">{{ $features[$key]['name'] }}</h3>
                            <p class="mt-2 text-texto-secundario">{{ $features[$key]['text'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Talleres que confían --}}
    <section id="clientes" class="seccion border-y border-borde bg-gris-50" aria-labelledby="clientes-title">
        <div class="contenedor grid gap-10 lg:grid-cols-[1.4fr_1fr] lg:items-center lg:gap-16">
            <figure data-revelar>
                <h2 id="clientes-title" class="t-etiqueta">Talleres que confían</h2>
                <blockquote class="mt-6 text-[22px] font-medium leading-[32px] tracking-[-0.01em] text-azul-800 before:mb-5 before:block before:text-[72px] before:font-bold before:leading-[0.6] before:text-celeste-500 before:content-['“'] md:text-[30px] md:leading-[42px]">
                    {{ $testimonial['quote'] }}
                </blockquote>
                <figcaption class="mt-6 text-texto-secundario">
                    <span class="font-bold text-azul-800">{{ $testimonial['author'] }}</span> · {{ $testimonial['role'] }}
                </figcaption>
            </figure>

            <ul data-revelar class="rounded-xl border border-borde bg-white p-6 sm:p-8">
                <li class="flex items-center gap-4">
                    <img src="{{ asset('logo sciaca.jpg') }}" alt="Logo de Taller Sciaca" width="480" height="480" loading="lazy" decoding="async" class="h-20 w-20 shrink-0 rounded-md object-contain">
                    <div>
                        <p class="font-bold text-azul-800">Taller Sciaca</p>
                        <p class="t-cuerpo-chico text-texto-secundario">Servicios para automotores</p>
                    </div>
                </li>
                <li class="mt-6 flex items-center gap-4 border-t border-borde pt-6">
                    <img src="{{ asset('logo mistage.png') }}" alt="Logo de Mistage" width="2000" height="1000" loading="lazy" decoding="async" class="h-20 w-40 shrink-0 object-contain">
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
            <ol class="mt-10 grid gap-8 md:mt-12 md:grid-cols-3 md:gap-8">
                @foreach ($steps as $step)
                    <li data-revelar class="grid grid-cols-[auto_1fr] gap-x-5 md:block">
                        <div class="hidden items-center gap-4 md:flex" aria-hidden="true">
                            <span class="h-4 w-4 shrink-0 rounded-full bg-celeste-500"></span>
                            @unless ($loop->last)
                                <span class="hidden h-0.5 flex-1 bg-gris-200 md:block"></span>
                            @endunless
                        </div>
                        <p class="t-display row-span-2 min-w-[3.25rem] text-celeste-700 md:mt-6">0{{ $loop->iteration }}</p>
                        <h3 class="t-titulo-3 self-end md:mt-3">{{ $step['title'] }}</h3>
                        <p class="col-start-2 mt-2 max-w-[34ch] text-texto-secundario">{{ $step['text'] }}</p>
                    </li>
                @endforeach
            </ol>
            <a href="{{ route('contacto') }}" class="boton boton-principal mt-10 w-full sm:w-auto md:mt-12" data-cta="demo">Pedí tu demo</a>
        </div>
    </section>

    {{-- Preguntas frecuentes --}}
    <section id="preguntas" class="seccion bg-gris-50" aria-labelledby="faq-title">
        <div class="contenedor">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-section-heading id="faq-title" eyebrow="Preguntas frecuentes" title="Antes de ver el sistema." />
                <a href="{{ config('landing.app_url') }}" class="boton boton-secundario w-full shrink-0 sm:w-auto">Calcular mi plan</a>
            </div>
            <dl class="mt-10 grid gap-x-12 gap-y-8 md:mt-12 md:grid-cols-2">
                @foreach ($faqs as $faq)
                    <div data-revelar class="border-t-2 border-azul-800 pt-5">
                        <dt class="t-titulo-3 text-azul-800">{{ $faq['q'] }}</dt>
                        <dd class="mt-2 max-w-[62ch] text-texto-secundario">
                            {{ $faq['a'] }}
                            @if (!empty($faq['cotizer']))
                                <a href="{{ config('landing.app_url') }}" class="enlace">También podés usar el cotizador.</a>
                            @endif
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- Cierre --}}
    <section class="relative overflow-hidden bg-azul-800 text-white" aria-labelledby="cierre-title">
        <x-nodos class="pointer-events-none absolute -right-20 top-1/2 hidden w-[460px] -translate-y-1/2 md:block" style="--nodos-base: var(--color-azul-700)" />
        <div class="contenedor relative py-16 md:py-24">
            <p class="t-etiqueta !text-celeste-400">IntegraTaller</p>
            <h2 id="cierre-title" class="t-display mt-4 !text-white">Tu taller, en orden.</h2>
            <p class="t-cuerpo-grande mt-4 max-w-[36rem] text-azul-100">Todas tus sucursales, un solo sistema. Te mostramos cómo funciona con el trabajo de tu taller.</p>
            <a href="{{ route('contacto') }}" class="boton boton-claro mt-8 w-full sm:w-auto" data-cta="demo">Pedí tu demo</a>
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

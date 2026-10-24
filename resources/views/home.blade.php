@extends('layouts.app')

@section('title', 'IntegraTaller | Tu taller, en orden.')
@section('meta_description', 'Órdenes de trabajo, clientes y finanzas de todas tus sucursales en un solo sistema. Para talleres mecánicos y de estética vehicular. Pedí tu demo.')

@php
    $precios = app(\App\Services\PlanesPublicos::class)->datos();

    $questions = [
        ['q' => '¿En qué quedó la Hilux que entró el lunes?', 'today' => 'Hoy: preguntás en el taller.'],
        ['q' => '¿Por qué no cierra la caja de Norte?', 'today' => 'Hoy: revisás planillas.'],
        ['q' => '¿Cuánto facturamos este mes entre todas las sedes?', 'today' => 'Hoy: sumás a mano.'],
        ['q' => '¿Quién hizo ese trabajo?', 'today' => 'Hoy: buscás en el chat.'],
    ];

    // Un caso de ejemplo: una camioneta que entra el lunes a la sucursal Norte y se entrega el martes
    $journey = [
        ['icon' => 'car', 'when' => 'Lunes 08:40', 'title' => 'Recepción', 'text' => 'Ingresa una Toyota Hilux por ruido al frenar. Se registran el cliente y el pedido, y la orden queda abierta.', 'status' => 'Ingresado', 'tone' => 'neutro'],
        ['icon' => 'search', 'when' => 'Lunes 10:15', 'title' => 'Presupuesto', 'text' => 'El diagnóstico indica cambio de pastillas y discos. El presupuesto se envía al cliente para su aprobación.', 'status' => 'Esperando aprobación', 'tone' => 'alerta'],
        ['icon' => 'wrench', 'when' => 'Lunes 12:30', 'title' => 'Trabajo en taller', 'text' => 'El cliente aprueba. La tarea queda asignada a un técnico y el avance se ve desde cualquier lugar.', 'status' => 'En proceso', 'tone' => 'info'],
        ['icon' => 'check', 'when' => 'Martes 16:00', 'title' => 'Listo para retirar', 'text' => 'El trabajo se termina y se prueba. Se avisa al cliente que puede retirar el vehículo.', 'status' => 'Listo', 'tone' => 'exito'],
        ['icon' => 'wallet', 'when' => 'Martes 18:20', 'title' => 'Cobro y cierre', 'text' => 'El pago ingresa a la caja de la sucursal Norte y la orden se cierra con todo su historial.', 'status' => 'Cerrado', 'tone' => 'cerrado'],
    ];

    $testimonial = collect(config('landing.testimonials', []))->first(fn ($t) => filled($t['quote'] ?? null));

    $features = [
        'sucursales' => ['icon' => 'store', 'name' => 'Varias sucursales', 'text' => 'Todas tus sedes en un mismo sistema, con la información separada y comparable. Mirá una por una o todas juntas.'],
        'ordenes' => ['icon' => 'clipboard', 'name' => 'Órdenes de trabajo', 'text' => 'Cada trabajo con sus tareas, repuestos, responsable y estado, desde el ingreso hasta la entrega.'],
        'clientes' => ['icon' => 'car', 'name' => 'Clientes y vehículos', 'text' => 'El historial de cada auto por patente y los datos del cliente a mano.'],
        'caja' => ['icon' => 'wallet', 'name' => 'Caja y finanzas', 'text' => 'Cobros, pagos y deudas de cada sucursal. Sabé cuánto facturaste hoy.'],
        'reportes' => ['icon' => 'bar-chart', 'name' => 'Reportes', 'text' => 'Facturación, órdenes y trabajos por sucursal, por período y por persona.'],
        'equipo' => ['icon' => 'users', 'name' => 'Equipo y permisos', 'text' => 'Cada persona ve y hace lo que le corresponde: dueño, encargado o recepción.'],
        'presupuestos' => ['icon' => 'send', 'name' => 'Presupuestos por WhatsApp', 'text' => 'Armás el presupuesto y se lo mandás con un toque: le llega el link al PDF. Cuando te dice que sí, lo aprobás y queda listo para cobrar.'],
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
        $precios
            ? ['q' => '¿Cuánto cuesta?', 'a' => 'El plan '.$precios['pro']['nombre'].' sale '.\App\Services\PlanesPublicos::pesos($precios['pro']['precio_final']).' por mes, final, con el precio de la beta'.($precios['pro']['descuento_pct'] > 0 ? ' (lista: '.\App\Services\PlanesPublicos::pesos($precios['pro']['precio']).')' : '').'. Es un precio fijo: incluye todas tus sucursales y todo tu equipo, sin costo extra.', 'precios' => true]
            : ['q' => '¿Cuánto cuesta?', 'a' => 'Depende de la cantidad de sucursales y personas. En la beta tenés 1 mes gratis y 50% de descuento. Escribinos y te pasamos el precio exacto para tu taller.', 'whatsapp' => true],
        ['q' => '¿Cómo funciona el mes gratis?', 'a' => 'Te registrás con tu cuenta de Google, cargás tu tarjeta en MercadoPago y no te cobramos nada por '.(($precios['prueba_dias'] ?? 0) > 0 ? $precios['prueba_dias'] : 30).' días. Si no te sirve, cancelás antes y no pagás nada.'],
        ['q' => '¿Tengo que firmar un contrato o hay permanencia?', 'a' => config('landing.copy.faq.permanencia')],
        ['q' => 'Tengo todo en Excel o en otro sistema, ¿cómo paso mis datos?', 'a' => 'Te acompañamos en la carga: sucursales, equipo, clientes y servicios, como contamos en "Cómo empezar". No arrancás de cero solo.'],
        ['q' => '¿Emite factura electrónica de ARCA?', 'a' => config('landing.copy.faq.arca'), 'whatsapp' => true],
        ['q' => '¿Qué pasa con mis datos? ¿Puedo exportarlos?', 'a' => config('landing.copy.faq.datos')],
        ['q' => '¿Qué pasa si se corta internet?', 'a' => config('landing.copy.faq.internet')],
        ['q' => '¿Puedo recibir consejos aunque todavía no quiera una demo?', 'a' => 'Sí. Suscribite a la guía mensual al pie de esta página: confirmás tu email y te das de baja cuando quieras.'],
    ];
    $riesgo = config('landing.copy.risk_reversal');
@endphp

@section('content')
    {{-- Portada --}}
    <section class="overflow-hidden bg-azul-800 text-white">
        <div class="contenedor grid items-center gap-8 pb-12 pt-7 md:gap-10 md:py-20 lg:grid-cols-[1fr_1.1fr] lg:gap-12 lg:py-28">
            {{-- Para quién es, la oferta y el botón tienen que verse sin desplazar, también en el navegador de Instagram;
                 por eso en el celular la descripción pasa debajo de los botones --}}
            <div class="portada-entrada flex flex-col">
                <p class="t-cuerpo-chico font-medium text-celeste-400 md:text-[15px]">
                    Para talleres con varias sucursales o equipos de 4 o más
                    <span class="oferta mt-2 flex w-fit md:mt-3">1 mes gratis + 50% en la beta</span>
                </p>
                <h1 class="t-display portada-titulo mt-4 max-w-[36rem] !text-white md:mt-5">El control de todas tus sucursales, en un solo sistema.</h1>
                <p class="mt-5 max-w-[32rem] text-azul-100 max-sm:order-1 md:mt-6 md:text-[18px] md:leading-7">
                    Órdenes de trabajo, clientes y finanzas centralizados. Sabé qué pasa en cada taller sin tener que estar ahí.
                </p>
                <div class="mt-5 md:mt-9">
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('contacto') }}" class="boton boton-claro" data-cta="demo">Pedí tu demo</a>
                        <a href="{{ \App\Support\Saas::signupUrl() }}" class="boton boton-borde-claro" data-cta="registro" data-registro>Probá 1 mes gratis</a>
                    </div>
                    {{-- TODO-CONFIRMAR: "Sin permanencia" (texto en config/landing.php, copy.risk_reversal) --}}
                    <p class="t-cuerpo-chico mt-3 text-azul-100">{{ $riesgo }}</p>
                    <a href="#como-funciona" class="t-cuerpo-chico mt-2 inline-flex items-center gap-1 font-medium text-azul-100 underline underline-offset-4 hover:text-white">Ver cómo funciona</a>
                </div>
                <p class="t-cuerpo-chico mt-6 text-azul-100 max-sm:order-2 md:mt-10">Talleres mecánicos y de estética vehicular · En la nube · Hecho en Argentina</p>
            </div>

            {{-- Captura real del tablero "Todas las sucursales" (datos ficticios de "Taller Demo") en un marco de celular hecho con CSS --}}
            <div class="portada-entrada flex justify-center lg:justify-end">
                <figure class="telefono w-[260px] sm:w-[290px]">
                    <img src="{{ asset('img/producto/panel-sucursales-celular.webp') }}"
                         alt="Tablero de IntegraTaller en el celular: órdenes por ingresar, en el taller y listas para retirar de las sucursales Centro, Norte y Sur"
                         width="600" height="1298" decoding="async" fetchpriority="high">
                </figure>
            </div>
        </div>
    </section>

    {{-- Las preguntas del dueño --}}
    <section class="seccion bg-white" aria-labelledby="preguntas-dueno-title">
        <div class="contenedor">
            <div data-revelar>
                <p class="t-etiqueta">El día a día</p>
                <h2 id="preguntas-dueno-title" class="t-titulo-1 mt-3 max-w-[680px]">Cuando el taller crece, las preguntas se repiten.</h2>
            </div>

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
            <x-section-heading data-revelar id="recorrido-title" align="center" eyebrow="Cómo funciona" title="Cada orden, del ingreso al cobro." subtitle="Un ejemplo: una camioneta entra el lunes a la mañana a la sucursal Norte y se entrega cobrada el martes a la tarde. Cada paso queda registrado." />

            <div class="recorrido relative mx-auto mt-12 max-w-[920px] md:mt-16">
                <div data-recorrido-pista class="absolute bottom-7 left-7 top-7 w-0.5 -translate-x-1/2 bg-gris-200 lg:left-1/2" aria-hidden="true">
                    <div class="recorrido-linea-progreso h-full w-full origin-top bg-azul-800"></div>
                </div>

                <ol class="relative grid gap-10 lg:gap-6">
                @foreach ($journey as $step)
                    <li class="recorrido-paso relative flex gap-5 lg:grid lg:grid-cols-[1fr_3.5rem_1fr] lg:items-start lg:gap-8">
                        <span class="recorrido-nodo relative z-10 inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-full lg:col-start-2 lg:row-start-1">
                            <x-icon :name="$step['icon']" class="h-6 w-6" />
                        </span>
                        <div @class([
                            'recorrido-contenido pt-1 lg:row-start-1 lg:pt-2',
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

            @if (filled(config('landing.video_url')))
                @include('partials.video', ['url' => config('landing.video_url'), 'poster' => config('landing.video_poster')])
            @endif
        </div>
    </section>

    {{-- Funciones --}}
    <section id="funciones" class="seccion bg-white" aria-labelledby="funciones-title">
        <div class="contenedor">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-section-heading data-revelar id="funciones-title" eyebrow="Funciones" title="Órdenes, clientes y finanzas. Todo en un lugar." />
                <a href="{{ route('servicios') }}" class="boton boton-terciario shrink-0 self-start !px-0 md:self-auto">
                    Ver todas las funciones
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>

            {{-- Capturas reales del sistema con datos ficticios ("Taller Demo"); reportes y equipo siguen con vistas de ejemplo --}}
            <div class="funciones-grilla mt-10 grid gap-4 md:mt-12 md:grid-cols-2 md:gap-5 lg:grid-cols-6">
                {{-- Sucursales: la idea central de la marca --}}
                <article data-revelar class="funcion funcion-destacada flex flex-col overflow-hidden p-6 text-white sm:p-8 md:col-span-2 md:min-h-[380px] md:p-10 lg:col-span-3 lg:row-span-2">
                    <x-nodos animado class="pointer-events-none absolute -bottom-24 -right-16 w-[300px] opacity-70 sm:-bottom-28 sm:-right-24 sm:w-[420px]" style="--nodos-base: var(--color-azul-700)" />
                    <div class="relative max-w-[340px]">
                        <p class="t-etiqueta !text-celeste-400">{{ $features['sucursales']['name'] }}</p>
                        <h3 class="t-titulo-1 mt-4 !text-white">Todas tus sucursales, un solo sistema.</h3>
                        <p class="t-cuerpo-grande mt-4 text-azul-100">{{ $features['sucursales']['text'] }}</p>
                    </div>
                    <ul class="relative mt-8 grid max-w-[300px] gap-2 lg:mt-auto lg:pt-10" aria-hidden="true">
                        @foreach ([['Centro', '12 en proceso'], ['Norte', 'Caja al día'], ['Sur', '3 por aprobar']] as [$sede, $dato])
                            <li class="flex items-center justify-between gap-4 rounded-md border border-azul-700 bg-azul-900/70 px-4 py-3 backdrop-blur-sm">
                                <span class="flex items-center gap-2 font-medium"><x-icon name="store" class="h-4 w-4 text-celeste-400" />{{ $sede }}</span>
                                <span class="t-cuerpo-chico text-celeste-400">{{ $dato }}</span>
                            </li>
                        @endforeach
                    </ul>
                </article>

                <article data-revelar class="funcion flex flex-col p-6 sm:p-8 lg:col-span-3">
                    <p class="t-etiqueta">{{ $features['ordenes']['name'] }}</p>
                    <h3 class="t-titulo-3 mt-3">Cada trabajo sabe en qué está.</h3>
                    <p class="mt-2 text-texto-secundario">{{ $features['ordenes']['text'] }}</p>
                    <div class="funcion-vista mt-6 overflow-hidden !p-0">
                        <img src="{{ asset('img/producto/orden-de-trabajo.webp') }}" alt="Orden de trabajo en IntegraTaller: estado, presupuesto aprobado, saldo pendiente y datos del cliente" width="1200" height="665" loading="lazy" decoding="async" class="w-full">
                    </div>
                </article>

                <article data-revelar class="funcion flex flex-col gap-6 p-6 sm:p-8 lg:col-span-3">
                    <div>
                        <p class="t-etiqueta">{{ $features['clientes']['name'] }}</p>
                        <h3 class="t-titulo-3 mt-3">La patente cuenta la historia.</h3>
                        <p class="mt-2 text-texto-secundario">{{ $features['clientes']['text'] }}</p>
                    </div>
                    <div class="funcion-vista w-full overflow-hidden !p-0">
                        <img src="{{ asset('img/producto/historial-patente.webp') }}" alt="Ficha de un vehículo por patente con su libreta de servicios: fechas, kilómetros, trabajos y montos" width="1200" height="780" loading="lazy" decoding="async" class="w-full">
                    </div>
                </article>

                @foreach (['caja', 'reportes', 'equipo'] as $key)
                    <article data-revelar @class([
                        'funcion flex flex-col p-6 sm:p-8 lg:col-span-2',
                        'md:col-span-2' => $loop->last,
                    ])>
                        <x-icon :name="$features[$key]['icon']" class="h-7 w-7 shrink-0 text-celeste-700 sm:h-8 sm:w-8" />
                        <h3 class="t-titulo-3 mt-5">{{ $features[$key]['name'] }}</h3>
                        <p class="mt-2 text-texto-secundario">{{ $features[$key]['text'] }}</p>

                        @if ($key === 'caja')
                            <div class="mt-auto pt-6"><div class="funcion-vista overflow-hidden !p-0">
                                <img src="{{ asset('img/producto/caja-del-dia.webp') }}" alt="Caja del día de una sucursal: ingresos y egresos con su detalle" width="800" height="195" loading="lazy" decoding="async" class="w-full">
                            </div></div>
                        @else
                        <div class="mt-auto pt-6" aria-hidden="true"><div class="funcion-vista">
                            @if ($key === 'reportes')
                                <ul class="grid gap-2">
                                    @foreach ([['Centro', 100], ['Norte', 72], ['Sur', 44]] as [$sede, $ancho])
                                        <li class="t-cuerpo-chico grid grid-cols-[3.5rem_1fr] items-center gap-3">
                                            <span class="text-texto-secundario">{{ $sede }}</span>
                                            <span class="funcion-barra h-3 rounded-sm bg-azul-800" style="width: {{ $ancho }}%"></span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <ul class="flex flex-wrap gap-2">
                                    @foreach ([['AS', 'Dueña'], ['MR', 'Encargado'], ['CL', 'Recepción']] as [$iniciales, $rol])
                                        <li class="t-cuerpo-chico inline-flex items-center gap-2 rounded-full bg-gris-100 py-1 pl-1 pr-3">
                                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-azul-800 text-[11px] font-bold text-white">{{ $iniciales }}</span>
                                            {{ $rol }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div></div>
                        @endif
                    </article>
                @endforeach

                {{-- Presupuestos por WhatsApp: el link al PDF sale con un toque; la aprobación se marca en el sistema --}}
                <article data-revelar class="funcion flex flex-col gap-6 p-6 sm:p-8 md:col-span-2 lg:col-span-6 lg:flex-row lg:items-center lg:gap-10">
                    <div class="lg:max-w-[380px]">
                        <p class="t-etiqueta">{{ $features['presupuestos']['name'] }}</p>
                        <h3 class="t-titulo-3 mt-3">El presupuesto le llega al cliente por WhatsApp.</h3>
                        <p class="mt-2 text-texto-secundario">{{ $features['presupuestos']['text'] }}</p>
                    </div>
                    <div class="funcion-vista w-full overflow-hidden !p-0 lg:flex-1">
                        <img src="{{ asset('img/producto/presupuesto-whatsapp.webp') }}" alt="Presupuesto en IntegraTaller con los botones Aprobar, Enviar al cliente por WhatsApp y Ver PDF" width="1000" height="244" loading="lazy" decoding="async" class="w-full">
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- Beneficios en plata: lo que el sistema hace de verdad (verificado en el SaaS) --}}
    <section class="seccion bg-azul-50" aria-labelledby="plata-title">
        <div class="contenedor">
            <x-section-heading data-revelar id="plata-title" eyebrow="Plata y control" title="Lo que hoy se te escapa, ahora queda a la vista." />
            <ul class="mt-10 grid gap-5 md:mt-12 md:grid-cols-3">
                @foreach ([
                    ['icon' => 'wallet', 'title' => 'Ninguna orden se te pasa sin cobrar.', 'text' => 'Cada orden muestra lo que falta cobrar y el tablero suma lo pendiente de todas las sucursales. Filtrás las órdenes con saldo y cobrás.'],
                    ['icon' => 'send', 'title' => 'Presupuestos que salen por WhatsApp en el momento.', 'text' => 'El cliente recibe el link al presupuesto en su WhatsApp. Cuando te dice que sí, lo aprobás con un toque y el trabajo arranca.'],
                    ['icon' => 'banknote', 'title' => 'La caja de cada sucursal, al día.', 'text' => 'Ingresos, egresos y el efectivo que tiene que haber en el cajón. Cerrás el día y comparás con lo contado.'],
                ] as $beneficio)
                    <li data-revelar class="tarjeta">
                        <x-icon :name="$beneficio['icon']" class="h-7 w-7 text-celeste-700" />
                        <h3 class="t-titulo-3 mt-4">{{ $beneficio['title'] }}</h3>
                        <p class="mt-2 text-texto-secundario">{{ $beneficio['text'] }}</p>
                    </li>
                @endforeach
            </ul>
            <p data-revelar class="t-titulo-3 mt-10 text-azul-800 md:mt-12">Con recuperar un trabajo sin cobrar por mes, el sistema se paga solo.</p>
        </div>
    </section>

    {{-- Talleres que confían --}}
    <section id="clientes" class="seccion border-y border-borde bg-gris-50" aria-labelledby="clientes-title">
        <div class="contenedor grid gap-10 lg:grid-cols-[1.4fr_1fr] lg:items-center lg:gap-16">
            {{-- Testimonio desde config('landing.testimonials'): foto, nombre, cargo, tamaño y video se muestran cuando estén cargados --}}
            <figure data-revelar>
                <h2 id="clientes-title" class="t-etiqueta">Talleres que confían</h2>
                @if ($testimonial)
                    <blockquote class="mt-6 text-[22px] font-medium leading-[32px] tracking-[-0.01em] text-azul-800 before:mb-5 before:block before:text-[72px] before:font-bold before:leading-[0.6] before:text-celeste-500 before:content-['“'] md:text-[30px] md:leading-[42px]">
                        {{ $testimonial['quote'] }}
                    </blockquote>
                    <figcaption class="mt-6 flex items-center gap-4 text-texto-secundario">
                        @if (filled($testimonial['photo'] ?? null))
                            <img src="{{ asset($testimonial['photo']) }}" alt="" width="112" height="112" loading="lazy" decoding="async" class="h-14 w-14 shrink-0 rounded-full object-cover">
                        @endif
                        <span>
                            @if (filled($testimonial['name'] ?? null))
                                <span class="block font-bold text-azul-800">{{ $testimonial['name'] }}</span>
                                <span class="block">{{ collect([$testimonial['role'] ?? null, $testimonial['company'] ?? null])->filter()->join(', ') }}</span>
                            @else
                                <span class="font-bold text-azul-800">{{ $testimonial['company'] }}</span> · {{ $testimonial['company_role'] ?? '' }}
                            @endif
                            @if (filled($testimonial['size'] ?? null))
                                <span class="t-cuerpo-chico block">{{ $testimonial['size'] }}</span>
                            @endif
                        </span>
                    </figcaption>
                    @if (filled($testimonial['video_url'] ?? null))
                        @include('partials.video', ['url' => $testimonial['video_url'], 'poster' => $testimonial['photo'] ?? config('landing.video_poster'), 'title' => 'Testimonio de '.$testimonial['company']])
                    @endif
                @endif
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

    @if ($precios)
        @include('partials.precios', ['precios' => $precios])
    @endif

    {{-- Cómo empezar --}}
    <section id="como-empezar" class="seccion bg-white" aria-labelledby="empezar-title">
        <div class="contenedor">
            <x-section-heading data-revelar id="empezar-title" eyebrow="Cómo empezar" title="Tres pasos y tu equipo ya está trabajando." />
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
                <x-section-heading data-revelar id="faq-title" eyebrow="Preguntas frecuentes" title="Antes de ver el sistema." />
                <a href="{{ \App\Support\WhatsApp::url() }}" target="_blank" rel="noopener noreferrer" class="boton boton-secundario w-full shrink-0 sm:w-auto">
                    <x-icon name="whatsapp" class="h-5 w-5" />
                    Cotizá por WhatsApp
                </a>
            </div>
            {{-- Más de 8 preguntas: desplegables nativos (<details>), accesibles con teclado y lector de pantalla --}}
            <div class="mt-10 grid gap-x-12 md:mt-12 md:grid-cols-2">
                @foreach ($faqs as $faq)
                    <details data-revelar class="pregunta border-t-2 border-azul-800">
                        <summary class="t-titulo-3 flex cursor-pointer items-start justify-between gap-4 py-5 text-azul-800">
                            {{ $faq['q'] }}
                            <x-icon name="chevron-down" class="pregunta-icono mt-1 h-5 w-5 shrink-0 text-celeste-700" />
                        </summary>
                        <div class="max-w-[62ch] pb-6 text-texto-secundario">
                            {{ $faq['a'] }}
                            @if (!empty($faq['precios']))
                                <a href="#precios" class="enlace">Ver precios.</a>
                            @endif
                            @if (!empty($faq['whatsapp']))
                                <a href="{{ \App\Support\WhatsApp::url() }}" target="_blank" rel="noopener noreferrer" class="enlace">También podés escribirnos por WhatsApp.</a>
                            @endif
                        </div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Cierre --}}
    <section class="relative overflow-hidden bg-azul-800 text-white" aria-labelledby="cierre-title">
        <x-nodos class="pointer-events-none absolute -right-20 top-1/2 hidden w-[460px] -translate-y-1/2 md:block" style="--nodos-base: var(--color-azul-700)" />
        <div data-revelar class="contenedor relative py-16 md:py-24">
            <p class="t-etiqueta !text-celeste-400">IntegraTaller</p>
            <h2 id="cierre-title" class="t-display mt-4 !text-white">Tu taller, en orden.</h2>
            <p class="t-cuerpo-grande mt-4 max-w-[36rem] text-azul-100">Todas tus sucursales, un solo sistema. Te mostramos cómo funciona con el trabajo de tu taller.</p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('contacto') }}" class="boton boton-claro" data-cta="demo">Pedí tu demo</a>
                <a href="{{ \App\Support\Saas::signupUrl() }}" class="boton boton-borde-claro" data-cta="registro" data-registro>Probá 1 mes gratis</a>
            </div>
            <p class="t-cuerpo-chico mt-3 text-azul-100">{{ $riesgo }}</p>
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
        ] + ($precios ? ['offers' => [
            '@type' => 'Offer',
            'name' => 'Plan '.$precios['pro']['nombre'],
            'price' => $precios['pro']['precio_final'],
            'priceCurrency' => 'ARS',
            'url' => url('/').'#precios',
            'priceSpecification' => [
                '@type' => 'UnitPriceSpecification',
                'price' => $precios['pro']['precio_final'],
                'priceCurrency' => 'ARS',
                'unitText' => 'mes',
                'billingDuration' => 'P1M',
            ],
        ]] : []), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
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

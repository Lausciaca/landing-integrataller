@extends('layouts.app')

@section('title', 'Software para talleres mecánicos en Argentina | IntegraTaller')
@section('meta_description', 'Software para talleres mecánicos en Argentina: turnos, órdenes de trabajo, historial por patente, control de stock y presupuestos por WhatsApp. Precios en pesos.')

@php
    $cotizar = config('landing.app_url');
    $whatsapp = 'https://wa.me/' . config('landing.whatsapp') . '?text=' . rawurlencode(config('landing.whatsapp_message'));

    $features = [
        [
            'slug' => 'historial-por-patente',
            'icon' => 'history',
            'problem' => '¿Perdés horas buscando qué se le hizo a un auto hace 6 meses?',
            'title' => 'Historial de vehículos por patente',
            'text' => 'Ingresá la patente y accedé al instante a todas las reparaciones previas, repuestos usados y diagnósticos de ese vehículo.',
        ],
        [
            'slug' => 'control-de-stock',
            'icon' => 'package',
            'problem' => '¿Los repuestos se "pierden" o no sabés cuánto stock real tenés en el galpón?',
            'title' => 'Control de stock de repuestos',
            'text' => 'Descontá repuestos, aceite y filtros automáticamente con cada orden de trabajo cerrada.',
        ],
        [
            'slug' => 'presupuestos-por-whatsapp',
            'icon' => 'receipt',
            'problem' => '¿Armar un presupuesto te frena el trabajo al final del día?',
            'title' => 'Presupuestos por WhatsApp en 2 clics',
            'text' => 'Armá la cotización con tus costos y enviala directamente al WhatsApp de tu cliente para que apruebe el trabajo.',
        ],
    ];

    $steps = [
        [
            'n' => '01',
            'icon' => 'settings',
            'title' => 'Personalizá',
            'text' => 'Entrá a nuestro cotizador y ajustá el plan a la medida de tu taller. Pagá solo por lo que usás.',
            'badge' => true,
        ],
        [
            'n' => '02',
            'icon' => 'credit-card',
            'title' => 'Activá',
            'text' => 'Realizá el pago de forma segura. Tu entorno de trabajo se crea automáticamente.',
            'mercadopago' => true,
        ],
        [
            'n' => '03',
            'icon' => 'gauge',
            'title' => 'Trabajá',
            'text' => 'Recibí tus accesos y empezá a cargar tus turnos al instante.',
        ],
    ];

    $faqs = [
        [
            'q' => '¿Cuánto cuesta el sistema?',
            'a' => 'El precio es dinámico y se ajusta al tamaño de tu taller. Hacé clic en "Cotizar" para calcular tu tarifa exacta en pesos, sin sorpresas ni costos ocultos en dólares.',
        ],
        [
            'q' => '¿Tengo que instalar algo en las computadoras?',
            'a' => 'No. El sistema es 100% en la nube. Solo necesitás internet. Funciona perfecto desde tu celular, tablet o la PC de la oficina.',
        ],
        [
            'q' => '¿Qué pasa si necesito ayuda para configurarlo?',
            'a' => 'Contamos con tutoriales paso a paso y soporte técnico directo por WhatsApp y tickets.',
        ],
    ];
@endphp

@section('content')
    {{-- 1. HERO --}}
    <section class="border-b border-line bg-white">
        <div class="container-page section-gap grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="reveal">
                <span class="badge bg-primary/10 text-primary">
                    <x-icon name="banknote" class="h-4 w-4" />
                    Precios en pesos · Sin costos en dólares
                </span>

                <h1 class="mt-6 text-[clamp(2.5rem,5vw,4rem)] font-black leading-[1.06] tracking-tight">
                    Software para talleres mecánicos: menos papeles, más vehículos entregados.
                    <span class="text-primary">Tomá el control de tu taller.</span>
                </h1>

                <p class="mt-6 max-w-[72ch] text-lg leading-relaxed text-secondary/70">
                    Gestioná turnos, órdenes de trabajo, stock y presupuestos desde el celular. El sistema que te
                    devuelve horas y deja de perder presupuestos.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ $cotizar }}" class="btn btn-primary px-7 py-4 text-lg" data-cta="cotizar">
                        Cotizá y activá tu sistema hoy
                        <x-icon name="arrow-right" class="h-5 w-5" />
                    </a>
                    <a href="{{ route('servicios') }}" class="btn btn-ghost px-7 py-4 text-lg">
                        Ver los módulos
                    </a>
                </div>

                <ul class="mt-8 flex flex-wrap gap-x-6 gap-y-2 text-sm font-medium text-secondary/70">
                    <li class="flex items-center gap-2">
                        <x-icon name="check" class="h-4 w-4 text-surface" /> Sin instalar nada
                    </li>
                    <li class="flex items-center gap-2">
                        <x-icon name="check" class="h-4 w-4 text-surface" /> Activación automática
                    </li>
                    <li class="flex items-center gap-2">
                        <x-icon name="check" class="h-4 w-4 text-surface" /> Soporte por WhatsApp
                    </li>
                </ul>
            </div>

            {{-- Mockup: dashboard de escritorio --}}
            <div class="reveal" data-delay="1">
                <div class="relative">
                    <div class="absolute -bottom-4 -top-6 inset-x-4 -z-10 rounded-lg bg-primary/5" aria-hidden="true"></div>

                    <div class="overflow-hidden rounded-lg border border-line bg-white" style="box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                        {{-- Barra del navegador --}}
                        <div class="flex items-center gap-3 border-b border-line bg-neutral px-4 py-3">
                            <div class="flex gap-1.5" aria-hidden="true">
                                <span class="h-2.5 w-2.5 rounded-full bg-danger/60"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-accent/70"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-surface/60"></span>
                            </div>
                            <div class="flex min-w-0 flex-1 items-center gap-2 rounded-sm border border-line bg-white px-3 py-1.5">
                                <x-icon name="lock" class="h-3.5 w-3.5 shrink-0 text-surface" />
                                <span class="truncate font-mono text-xs text-secondary/70">app.integrataller.com/panel</span>
                            </div>
                        </div>

                        <div class="flex">
                            {{-- Sidebar --}}
                            <aside class="hidden w-44 shrink-0 border-r border-line bg-neutral p-3 sm:block">
                                <div class="flex items-center gap-2 px-2 py-1">
                                    <img src="{{ asset('isotipo-128.png') }}" alt="" aria-hidden="true" width="128" height="128" decoding="async" class="h-6 w-6">
                                    <span class="text-sm font-black leading-none">Integra<span class="text-primary">Taller</span></span>
                                </div>
                                <nav class="mt-3 space-y-1">
                                    @foreach ([
                                        ['icon' => 'gauge', 'label' => 'Panel', 'active' => true],
                                        ['icon' => 'clipboard', 'label' => 'Órdenes', 'active' => false],
                                        ['icon' => 'package', 'label' => 'Stock', 'active' => false],
                                        ['icon' => 'bar-chart', 'label' => 'Caja', 'active' => false],
                                        ['icon' => 'users', 'label' => 'Clientes', 'active' => false],
                                    ] as $item)
                                        <span @class([
                                            'flex items-center gap-2 rounded-sm px-2 py-2 text-sm font-medium',
                                            'bg-primary/10 text-primary' => $item['active'],
                                            'text-secondary/70' => ! $item['active'],
                                        ])>
                                            <x-icon :name="$item['icon']" class="h-4 w-4" />
                                            {{ $item['label'] }}
                                        </span>
                                    @endforeach
                                </nav>
                            </aside>

                            {{-- Panel principal --}}
                            <div class="min-w-0 flex-1 p-4 sm:p-5">
                                <div class="flex items-center justify-between gap-2">
                                    <div>
                                        <p class="text-sm font-bold">Panel del taller</p>
                                        <p class="text-xs text-secondary/70">Martes 22 · Taller El Rayo</p>
                                    </div>
                                    <span class="badge bg-surface/15 text-surface-ink">
                                        <span class="h-1.5 w-1.5 rounded-full bg-surface"></span> Operativo
                                    </span>
                                </div>

                                {{-- KPIs --}}
                                <div class="mt-4 grid grid-cols-2 gap-2 sm:grid-cols-3">
                                    <div class="rounded-sm border border-line p-3">
                                        <x-icon name="car" class="h-4 w-4 text-primary" />
                                        <p class="mt-2 font-mono text-xl font-bold leading-none">7</p>
                                        <p class="mt-1 text-xs text-secondary/70">En taller</p>
                                    </div>
                                    <div class="rounded-sm border border-line p-3">
                                        <x-icon name="send" class="h-4 w-4 text-info" />
                                        <p class="mt-2 font-mono text-xl font-bold leading-none">4</p>
                                        <p class="mt-1 text-xs text-secondary/70">Presupuestos</p>
                                    </div>
                                    <div class="col-span-2 rounded-sm border border-line p-3 sm:col-span-1">
                                        <x-icon name="banknote" class="h-4 w-4 text-surface" />
                                        <p class="mt-2 font-mono text-xl font-bold leading-none">$185.000</p>
                                        <p class="mt-1 text-xs text-secondary/70">Caja del día</p>
                                    </div>
                                </div>

                                {{-- Órdenes --}}
                                <div class="mt-4">
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs font-bold uppercase tracking-wide text-secondary/70">Órdenes en curso</p>
                                        <span class="text-xs font-semibold text-primary">Ver todas</span>
                                    </div>
                                    <ul class="mt-2 space-y-2">
                                        <li class="flex flex-wrap items-center justify-between gap-2 rounded-sm border border-line p-2">
                                            <div class="min-w-0">
                                                <p class="font-mono text-sm font-bold tracking-wide">AB123CD</p>
                                                <p class="truncate text-xs text-secondary/70">Cambio de aceite</p>
                                            </div>
                                            <span class="badge bg-accent/20 text-accent-ink">En diagnóstico</span>
                                        </li>
                                        <li class="flex flex-wrap items-center justify-between gap-2 rounded-sm border border-line p-2">
                                            <div class="min-w-0">
                                                <p class="font-mono text-sm font-bold tracking-wide">LM456EF</p>
                                                <p class="truncate text-xs text-secondary/70">Frenos delanteros</p>
                                            </div>
                                            <span class="badge bg-surface/15 text-surface-ink">Listo</span>
                                        </li>
                                        <li class="flex flex-wrap items-center justify-between gap-2 rounded-sm border border-line p-2">
                                            <div class="min-w-0">
                                                <p class="font-mono text-sm font-bold tracking-wide">GH789IJ</p>
                                                <p class="truncate text-xs text-secondary/70">Distribución</p>
                                            </div>
                                            <span class="badge bg-info/15 text-info-ink">Presupuesto</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -bottom-5 -left-4 hidden items-center gap-2 rounded-sm border border-line bg-white px-3 py-2 sm:flex" style="box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                        <x-icon name="whatsapp" class="h-5 w-5 text-surface" />
                        <span class="text-xs font-semibold">Presupuesto enviado</span>
                    </div>

                    <div class="absolute -right-4 -top-5 hidden items-center gap-2 rounded-sm border border-line bg-white px-3 py-2 lg:flex" style="box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                        <x-icon name="package" class="h-5 w-5 text-accent" />
                        <span class="text-xs font-semibold">Stock bajo: filtros</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. PROBLEMA VS SOLUCIÓN --}}
    <section class="border-b border-line bg-white">
        <div class="container-page section-gap">
            <x-section-heading
                eyebrow="Problema vs. Solución"
                title="Los dolores de cabeza del taller, resueltos."
                subtitle="Cada módulo nace de un problema real del día a día. Sin funciones de relleno."
            />

            <div class="mt-14 space-y-16 lg:space-y-20">
                @foreach ($features as $i => $feature)
                    @php $flip = $i % 2 === 1; @endphp
                    <div class="grid items-center gap-8 lg:grid-cols-2 lg:gap-14">
                        <div class="reveal {{ $flip ? 'lg:order-2' : '' }}">
                            <p class="text-sm font-bold uppercase tracking-[0.14em] text-danger">El problema</p>
                            <h3 class="mt-3 text-2xl font-bold leading-snug text-secondary/70 sm:text-3xl">
                                {{ $feature['problem'] }}
                            </h3>
                        </div>

                        <div class="reveal {{ $flip ? 'lg:order-1' : '' }}" data-delay="1">
                            <div class="card">
                                <p class="text-sm font-bold uppercase tracking-[0.14em] text-primary">La solución</p>
                                <span class="mt-4 inline-flex h-12 w-12 items-center justify-center rounded-sm bg-primary/10 text-primary">
                                    <x-icon :name="$feature['icon']" class="h-6 w-6" />
                                </span>
                                <h4 class="mt-4 text-xl font-bold">
                                    <a href="{{ route('features.show', $feature['slug']) }}" class="transition-colors hover:text-primary">
                                        {{ $feature['title'] }}
                                    </a>
                                </h4>
                                <p class="mt-2 leading-relaxed text-secondary/70">{{ $feature['text'] }}</p>
                                <a href="{{ route('features.show', $feature['slug']) }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                                    Ver más
                                    <x-icon name="chevron-right" class="h-4 w-4" />
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3. CÓMO FUNCIONA --}}
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <x-section-heading
                eyebrow="Onboarding automático"
                title="Tu taller con software de gestión en 3 pasos, sin esperar a un vendedor"
                subtitle="Sin reuniones, sin demo de una hora. Vos mismo activás tu sistema."
            />

            <ol class="relative mt-16 lg:grid lg:grid-cols-3 lg:gap-8">
                {{-- Conector: vertical en móvil, horizontal en desktop --}}
                <span class="absolute bottom-6 left-6 top-6 w-px bg-line lg:hidden" aria-hidden="true"></span>
                <span class="absolute left-6 right-6 top-6 hidden h-px bg-line lg:block" aria-hidden="true"></span>

                @foreach ($steps as $step)
                    <li class="reveal relative flex gap-4 pb-10 last:pb-0 lg:block lg:pb-0" data-delay="{{ $loop->index }}">
                        <span class="relative z-10 flex h-12 w-12 shrink-0 items-center justify-center rounded-full border-2 border-primary bg-white font-mono text-base font-bold text-primary">
                            {{ $step['n'] }}
                        </span>

                        <div class="lg:mt-6">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-sm bg-secondary text-white">
                                <x-icon :name="$step['icon']" class="h-5 w-5" />
                            </span>

                            <h3 class="mt-4 text-xl font-bold">{{ $step['title'] }}</h3>
                            <p class="mt-2 max-w-[72ch] leading-relaxed text-secondary/70">{{ $step['text'] }}</p>

                            @if (!empty($step['badge']))
                                <div class="mt-4">
                                    <span class="badge bg-accent/20 text-accent-ink">
                                        <x-icon name="banknote" class="h-4 w-4" />
                                        Precios 100% en Pesos Argentinos (AR$)
                                    </span>
                                </div>
                            @endif

                            @if (!empty($step['mercadopago']))
                                <div class="mt-4">
                                    <span class="inline-flex items-center gap-2 rounded-sm border border-line bg-white px-3 py-2">
                                        <x-icon name="credit-card" class="h-5 w-5 text-info" />
                                        <span class="text-sm font-semibold">Mercado Pago</span>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- 4. FAQ --}}
    <section class="border-b border-line bg-white">
        <div class="container-page section-gap">
            <x-section-heading eyebrow="Preguntas frecuentes" title="Preguntas frecuentes sobre el software para talleres" />

            <div class="mx-auto mt-12 max-w-3xl divide-y divide-line border-y border-line">
                @foreach ($faqs as $faq)
                    <details class="group" @if ($loop->first) open @endif>
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 py-5 text-left transition-colors hover:text-primary marker:content-none">
                            <h3 class="text-lg font-bold">{{ $faq['q'] }}</h3>
                            <x-icon name="chevron-down" class="h-5 w-5 shrink-0 text-primary transition-transform duration-200 group-open:rotate-180" />
                        </summary>
                        <p class="pb-5 leading-relaxed text-secondary/70">{{ $faq['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Enlaces internos SEO --}}
    <section class="border-b border-line bg-neutral">
        <div class="container-page py-12">
            <div class="grid gap-8 md:grid-cols-2">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-[0.14em] text-secondary/70">Características</h2>
                    <ul class="mt-4 space-y-2">
                        @foreach (config('seo.features') as $slug => $featureLink)
                            <li>
                                <a href="{{ route('features.show', $slug) }}" class="font-medium text-primary hover:underline">
                                    {{ $featureLink['h1'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-[0.14em] text-secondary/70">Talleres por ciudad</h2>
                    <ul class="mt-4 space-y-2">
                        @foreach (config('seo.cities') as $slug => $cityLink)
                            <li>
                                <a href="{{ route('cities.show', $slug) }}" class="font-medium text-primary hover:underline">
                                    Software para talleres en {{ $cityLink['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. CTA FINAL --}}
    <section class="bg-primary text-white">
        <div class="container-page section-gap text-center">
            <h2 class="mx-auto max-w-2xl text-3xl font-black tracking-tight text-white sm:text-4xl">
                No dejes que el desorden frene el crecimiento de tu taller.
            </h2>
            <p class="mx-auto mt-4 max-w-xl text-lg text-white/80">
                Activá el software para tu taller hoy, sin instalar nada ni esperar a un vendedor.
            </p>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ $cotizar }}" class="btn btn-inverse px-7 py-4 text-lg" data-cta="cotizar">
                    Ir al Cotizador
                    <x-icon name="arrow-right" class="h-5 w-5" />
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn border border-white/40 px-7 py-4 text-lg text-white hover:bg-white/10">
                    <x-icon name="whatsapp" class="h-5 w-5" />
                    Hablar por WhatsApp
                </a>
            </div>
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
            'description' => 'Software para talleres mecánicos: gestión de turnos, órdenes de trabajo, historial por patente, stock y presupuestos por WhatsApp.',
            'areaServed' => ['@type' => 'Country', 'name' => 'Argentina'],
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => 'ARS',
                'price' => '0',
                'description' => 'Precio dinámico según el tamaño del taller. Cotización en pesos argentinos.',
                'url' => config('landing.app_url'),
            ],
            'featureList' => [
                'Historial de vehículos por patente',
                'Gestión de turnos y órdenes de trabajo',
                'Control de stock de repuestos',
                'Presupuestos por WhatsApp',
                'Caja y finanzas del taller',
            ],
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

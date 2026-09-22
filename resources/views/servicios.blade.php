@extends('layouts.app')

@section('title', 'Software para talleres mecánicos: módulos y soporte | IntegraTaller')
@section('meta_description', 'Módulos de software para talleres mecánicos: órdenes de trabajo, control de stock de repuestos, caja y finanzas, y avisos automáticos por WhatsApp. Soporte 24/7.')

@php
    $cotizar = config('landing.app_url');
    $whatsapp = 'https://wa.me/' . config('landing.whatsapp') . '?text=' . rawurlencode(config('landing.whatsapp_message'));

    $modules = [
        [
            'icon' => 'clipboard',
            'title' => 'Órdenes de Trabajo',
            'text' => 'Desde el ingreso hasta la entrega. Registrá fallas reportadas, tareas realizadas, horas de mano de obra y mecánicos asignados.',
        ],
        [
            'icon' => 'package',
            'title' => 'Control de Stock y Proveedores',
            'text' => 'Mantené el control de tus repuestos. Alertas de bajo stock y registro de costos de lubricantes, filtros y piezas.',
        ],
        [
            'icon' => 'bar-chart',
            'title' => 'Caja y Finanzas',
            'text' => 'Conocé exactamente cuánto entró y cuánto salió en el día. Reportes claros para entender la rentabilidad de tu negocio.',
        ],
        [
            'icon' => 'bell',
            'title' => 'Avisos Automáticos',
            'text' => 'Mantené a tu cliente informado. Actualizaciones del estado del vehículo ("En diagnóstico", "Listo para retirar") listas para enviar por WhatsApp.',
        ],
    ];
@endphp

@section('content')
    {{-- CABECERA --}}
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <x-section-heading
                level="h1"
                eyebrow="Servicios y Soporte"
                title="Las herramientas exactas que tu taller necesita."
                subtitle="Módulos de software para talleres mecánicos que resuelven los cuellos de botella de la mecánica."
            />

            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ $cotizar }}" class="btn btn-primary px-7 py-4 text-lg" data-cta="cotizar">
                    Cotizar mi sistema
                    <x-icon name="arrow-right" class="h-5 w-5" />
                </a>
                <a href="{{ route('tutoriales') }}" class="btn btn-ghost px-7 py-4 text-lg">
                    Ver tutoriales
                </a>
            </div>
        </div>
    </section>

    {{-- GRILLA DE MÓDULOS --}}
    <section class="border-b border-line bg-white">
        <div class="container-page section-gap">
            <div class="grid gap-6 md:grid-cols-2">
                @foreach ($modules as $module)
                    <article class="reveal card flex flex-col" data-delay="{{ $loop->index % 2 }}">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-sm bg-primary/10 text-primary">
                            <x-icon :name="$module['icon']" class="h-6 w-6" />
                        </span>
                        <h2 class="mt-4 text-xl font-bold">{{ $module['title'] }}</h2>
                        <p class="mt-2 leading-relaxed text-secondary/70">{{ $module['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- PROMESA DE SOPORTE --}}
    <section class="border-b border-line bg-white">
        <div class="container-page section-gap">
            <div class="grid items-center gap-10 rounded-lg border border-line bg-neutral p-8 lg:grid-cols-[1.1fr_0.9fr] lg:p-12">
                <div class="reveal">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-sm bg-surface text-white">
                        <x-icon name="shield-check" class="h-6 w-6" />
                    </span>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        Soporte técnico que no te deja a pie.
                    </h2>
                    <p class="mt-4 text-lg leading-relaxed text-secondary/70">
                        Si el sistema frena, el taller frena. Por eso te ofrecemos monitoreo 24/7, copias de
                        seguridad automáticas y atención rápida a través de nuestro sistema de tickets y WhatsApp.
                    </p>
                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp px-6 py-3.5">
                            <x-icon name="whatsapp" class="h-5 w-5" />
                            Hablar con soporte
                        </a>
                        <a href="{{ route('contacto') }}" class="btn btn-ghost px-6 py-3.5">
                            Abrir un ticket
                        </a>
                    </div>
                </div>

                <ul class="grid gap-3">
                    @foreach ([
                        ['icon' => 'clock', 'label' => 'Monitoreo 24/7', 'text' => 'Vigilamos la plataforma todos los días del año.'],
                        ['icon' => 'cloud', 'label' => 'Backups automáticos', 'text' => 'Tu información respaldada sin que tengas que hacer nada.'],
                        ['icon' => 'ticket', 'label' => 'Atención por tickets', 'text' => 'Seguimiento ordenado de cada caso técnico.'],
                    ] as $item)
                        <li class="reveal flex items-start gap-4 rounded-sm border border-line bg-white p-4" data-delay="1">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-sm bg-primary/10 text-primary">
                                <x-icon :name="$item['icon']" class="h-5 w-5" />
                            </span>
                            <span>
                                <span class="block font-bold">{{ $item['label'] }}</span>
                                <span class="block text-sm leading-relaxed text-secondary/70">{{ $item['text'] }}</span>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-secondary text-white">
        <div class="container-page section-gap text-center">
            <h2 class="mx-auto max-w-2xl text-3xl font-black tracking-tight text-white sm:text-4xl">
                Todo tu taller en un solo sistema.
            </h2>
            <a href="{{ $cotizar }}" class="btn btn-primary mt-8 px-7 py-4 text-lg" data-cta="cotizar">
                Cotizá y activá tu sistema hoy
                <x-icon name="arrow-right" class="h-5 w-5" />
            </a>
        </div>
    </section>
@endsection

@push('head')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'Módulos de software para talleres mecánicos',
            'itemListElement' => collect($modules)->values()->map(fn ($module, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'item' => [
                    '@type' => 'Service',
                    'name' => $module['title'],
                    'description' => $module['text'],
                    'provider' => ['@type' => 'Organization', 'name' => 'IntegraTaller'],
                    'areaServed' => ['@type' => 'Country', 'name' => 'Argentina'],
                ],
            ])->all(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

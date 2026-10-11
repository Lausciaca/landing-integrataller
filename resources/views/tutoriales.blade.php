@extends('layouts.app')

@section('title', 'Guías prácticas para talleres mecánicos | IntegraTaller')
@section('meta_description', 'Recibí ideas y guías prácticas para ordenar turnos, órdenes de trabajo, stock y presupuestos en tu taller mecánico.')

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <p class="section-kicker">Biblioteca del taller</p>
            <h1 class="display-title mt-5 max-w-[11ch]">Ideas prácticas para que el trabajo fluya.</h1>
            <p class="mt-6 max-w-[55ch] text-lg leading-relaxed text-secondary/75">Estamos preparando guías claras para los desafíos de todos los días. Suscribite y te avisamos cuando estén listas.</p>
        </div>
    </section>

    <section class="bg-white">
        <div class="container-page section-gap">
            <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:gap-20">
                <div>
                    <p class="section-kicker">Próximos temas</p>
                    <h2 class="mt-4 max-w-[10ch] font-display text-4xl font-semibold leading-none sm:text-5xl">Herramientas que podés llevar al taller.</h2>
                </div>
                <ul class="border-t-2 border-secondary">
                    @foreach (['Preparar la agenda y recibir vehículos', 'Mantener al día órdenes y tareas', 'Llevar un control claro de repuestos', 'Compartir presupuestos con clientes'] as $guide)
                        <li class="flex items-start gap-4 border-b border-line py-5">
                            <span class="mt-1 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-accent/25 text-primary">
                                <x-icon name="arrow-right" class="h-4 w-4" />
                            </span>
                            <span class="font-display text-2xl font-semibold">{{ $guide }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section class="bg-primary-deep text-white">
        <div class="container-page grid gap-8 py-12 md:grid-cols-[1fr_0.9fr] md:items-center md:gap-16 md:py-16">
            <div>
                <p class="section-kicker !text-white before:!bg-accent">Sin mensajes de más</p>
                <h2 class="mt-4 font-display text-4xl font-semibold leading-none text-white sm:text-5xl">Te avisamos cuando salga una guía nueva.</h2>
                <p class="mt-4 max-w-[50ch] leading-relaxed text-white/75">Un correo al mes con contenido práctico y novedades de IntegraTaller. Confirmás tu email antes de recibirlos.</p>
            </div>
            <div class="rounded-sm bg-white p-5 text-secondary sm:p-7">
                @include('partials.newsletter-form', ['source' => 'guias'])
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="container-page flex flex-col gap-5 py-10 sm:flex-row sm:items-center sm:justify-between">
            <p class="max-w-[55ch] text-secondary/75">¿Querés conocer el sistema antes de suscribirte a las guías?</p>
            <a href="{{ route('contacto') }}" class="font-bold text-primary underline decoration-primary/30 underline-offset-4 hover:decoration-primary" data-cta="demo">Solicitar una demo</a>
        </div>
    </section>
@endsection

@push('head')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Guías prácticas para talleres mecánicos',
            'url' => route('tutoriales'),
            'inLanguage' => 'es-AR',
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

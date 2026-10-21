@extends('layouts.app')

@section('title', 'Pedí tu demo | IntegraTaller')
@section('meta_description', 'Contanos sobre tu taller y coordinamos una demo de IntegraTaller: órdenes, clientes y finanzas de todas tus sucursales en un solo sistema.')
@section('canonical', route('contacto'))

@section('content')
    <section class="bg-gris-50">
        <div class="contenedor grid gap-10 py-14 md:grid-cols-[0.9fr_1.1fr] md:gap-16 md:py-20">
            <div>
                <p class="t-etiqueta">Pedí tu demo</p>
                <h1 class="t-display mt-4">Veamos cómo funciona en tu taller.</h1>
                <p class="t-cuerpo-grande mt-5 max-w-[30rem] text-texto-secundario">Dejanos tres datos y te escribimos por WhatsApp para coordinar una demo según cómo trabaja tu taller.</p>
                <span class="oferta mt-6">1 mes gratis + 50% en la beta</span>

                <ul class="mt-8 space-y-3">
                    @foreach (['Te mostramos órdenes, clientes, caja y sucursales.', 'Respondemos tus dudas sobre tu caso.', 'Te pasamos el precio para tu taller.'] as $item)
                        <li class="flex items-start gap-3">
                            <x-icon name="check" class="mt-0.5 h-5 w-5 shrink-0 text-exito" />
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-10 border-t border-borde pt-6">
                    <p class="font-medium text-azul-800">¿Preferís escribir primero?</p>
                    <a href="{{ \App\Support\WhatsApp::url() }}" target="_blank" rel="noopener noreferrer" class="enlace mt-2 inline-flex items-center gap-2">
                        <x-icon name="whatsapp" class="h-5 w-5" />
                        Escribinos por WhatsApp
                    </a>
                </div>
            </div>

            <div class="tarjeta !p-6 shadow-2 sm:!p-8">
                <h2 class="t-titulo-2">Tus datos</h2>
                <p class="t-cuerpo-chico mt-1 text-texto-secundario">Te lleva menos de un minuto.</p>

                @if ($errors->any())
                    <div class="aviso aviso-error mt-6" role="alert">
                        <x-icon name="alert-circle" class="h-5 w-5 shrink-0" />
                        <p><span class="font-medium">Revisá los campos marcados.</span> Hay datos que faltan o no son válidos.</p>
                    </div>
                @endif

                <div class="mt-6">
                    @include('partials.demo-form')
                </div>
            </div>
        </div>
    </section>
@endsection

@push('head')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'name' => 'Pedí tu demo — IntegraTaller',
            'url' => route('contacto'),
            'inLanguage' => 'es-AR',
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

@extends('layouts.app')

@section('title', 'Contacto: cotizá tu software de taller | IntegraTaller')
@section('meta_description', 'Hablemos de tu taller. Escribinos por WhatsApp o dejanos tus datos y te contactamos. Soporte técnico para usuarios del sistema de gestión.')

@php
    $cotizar = config('landing.app_url');
    $whatsapp = 'https://wa.me/' . config('landing.whatsapp') . '?text=' . rawurlencode(config('landing.whatsapp_message'));
@endphp

@section('content')
    {{-- CABECERA --}}
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <x-section-heading
                level="h1"
                eyebrow="Contacto"
                title="Hablemos de tu taller."
                subtitle="¿Tenés dudas sobre cómo se adapta el software de gestión a tu forma de trabajo? Escribinos."
            />
        </div>
    </section>

    {{-- AVISO DE SOPORTE --}}
    <div class="border-b border-line bg-white">
        <div class="container-page py-6">
            <div class="flex flex-col items-start gap-4 rounded-lg border border-info/30 bg-info/5 p-5 sm:flex-row sm:items-center">
                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-sm bg-info text-white">
                    <x-icon name="ticket" class="h-5 w-5" />
                </span>
                <p class="text-secondary/80">
                    <span class="font-bold">¿Ya sos usuario del sistema?</span>
                    Para asistencia técnica rápida, ingresá a tu cuenta y generá un ticket de soporte.
                </p>
                <a href="{{ $cotizar }}" class="btn btn-ghost shrink-0 sm:ml-auto" data-cta="app">
                    Ir a mi cuenta
                </a>
            </div>
        </div>
    </div>

    {{-- LAYOUT DE CONTACTO --}}
    <section class="bg-white">
        <div class="container-page section-gap">
            <div class="grid gap-8 lg:grid-cols-2 lg:gap-12">
                {{-- COLUMNA 1: WHATSAPP --}}
                <div class="reveal flex flex-col rounded-lg bg-secondary p-8 text-white lg:p-10">
                    <span class="inline-flex h-14 w-14 items-center justify-center rounded-sm bg-surface text-white">
                        <x-icon name="whatsapp" class="h-8 w-8" />
                    </span>
                    <h2 class="mt-5 text-3xl font-bold tracking-tight text-white">La vía más rápida</h2>
                    <p class="mt-3 text-lg leading-relaxed text-white/70">
                        Respondemos al toque. Contanos qué necesitás y te ayudamos a elegir el plan justo para tu taller.
                    </p>

                    <a href="{{ $whatsapp }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="btn btn-whatsapp mt-8 w-full px-6 py-5 text-xl">
                        <x-icon name="whatsapp" class="h-7 w-7" />
                        Escribinos por WhatsApp
                    </a>

                    <ul class="mt-8 space-y-3 text-sm text-white/70">
                        <li class="flex items-center gap-3">
                            <x-icon name="clock" class="h-5 w-5 text-surface" />
                            Respuesta en el día, de lunes a sábado.
                        </li>
                        <li class="flex items-center gap-3">
                            <x-icon name="check" class="h-5 w-5 text-surface" />
                            Sin formularios largos ni llamadas obligatorias.
                        </li>
                    </ul>
                </div>

                {{-- COLUMNA 2: FORMULARIO --}}
                <div class="reveal card lg:p-8" data-delay="1">
                    <p class="text-lg font-bold">O dejanos tus datos y te contactamos:</p>

                    @if (session('status'))
                        <div class="mt-5 flex items-start gap-3 rounded-sm border border-surface/30 bg-surface/10 p-4 text-sm">
                            <x-icon name="check" class="h-5 w-5 shrink-0 text-surface" />
                            <p class="text-secondary/80">{{ session('status') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contacto.store') }}" class="mt-6 space-y-5">
                        @csrf

                        <div>
                            <label for="nombre" class="label">Nombre</label>
                            <input id="nombre" name="name" type="text" value="{{ old('name') }}" required
                                   class="input @error('name') border-danger @enderror" placeholder="Tu nombre y apellido">
                            @error('name') <span class="field-error">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="taller" class="label">Taller</label>
                            <input id="taller" name="taller" type="text" value="{{ old('taller') }}" required
                                   class="input @error('taller') border-danger @enderror" placeholder="Nombre de tu taller">
                            @error('taller') <span class="field-error">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="celular" class="label">Celular</label>
                            <input id="celular" name="phone" type="tel" value="{{ old('phone') }}" required
                                   inputmode="tel" class="input @error('phone') border-danger @enderror" placeholder="Ej: 336 400 6452">
                            @error('phone') <span class="field-error">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="consulta" class="label">Consulta</label>
                            <textarea id="consulta" name="message" rows="4" required
                                      class="input resize-y @error('message') border-danger @enderror"
                                      placeholder="Contanos qué necesitás">{{ old('message') }}</textarea>
                            @error('message') <span class="field-error">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-full px-6 py-4 text-lg">
                            <x-icon name="send" class="h-5 w-5" />
                            Enviar Mensaje
                        </button>
                    </form>
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
            'name' => 'Contacto — IntegraTaller',
            'url' => route('contacto'),
            'inLanguage' => 'es-AR',
            'mainEntity' => [
                '@type' => 'Organization',
                'name' => 'IntegraTaller',
                'contactPoint' => [[
                    '@type' => 'ContactPoint',
                    'telephone' => '+' . config('landing.whatsapp'),
                    'contactType' => 'sales',
                    'areaServed' => 'AR',
                    'availableLanguage' => ['es'],
                ]],
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

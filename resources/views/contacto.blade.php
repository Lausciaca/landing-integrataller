@extends('layouts.app')

@section('title', 'Pedí tu demo | IntegraTaller')
@section('meta_description', 'Contanos sobre tu taller y coordinamos una demo de IntegraTaller: órdenes, clientes y finanzas de todas tus sucursales en un solo sistema.')
@section('canonical', route('contacto'))

@php
    $whatsapp = 'https://wa.me/' . config('landing.whatsapp') . '?text=' . rawurlencode('Hola, quiero conocer IntegraTaller para mi taller.');
    $fields = [
        ['id' => 'name', 'label' => 'Tu nombre', 'type' => 'text', 'autocomplete' => 'name', 'max' => 120, 'placeholder' => 'Nombre y apellido'],
        ['id' => 'taller', 'label' => 'Nombre del taller', 'type' => 'text', 'autocomplete' => 'organization', 'max' => 120, 'placeholder' => 'Tu taller'],
        ['id' => 'email', 'label' => 'Email', 'type' => 'email', 'autocomplete' => 'email', 'max' => 254, 'placeholder' => 'nombre@taller.com'],
        ['id' => 'phone', 'label' => 'WhatsApp o celular', 'type' => 'tel', 'autocomplete' => 'tel', 'max' => 40, 'placeholder' => 'Código de área + número'],
    ];
@endphp

@section('content')
    <section class="bg-gris-50">
        <div class="contenedor grid gap-10 py-14 md:grid-cols-[0.9fr_1.1fr] md:gap-16 md:py-20">
            <div>
                <p class="t-etiqueta">Pedí tu demo</p>
                <h1 class="t-display mt-4">Veamos cómo funciona en tu taller.</h1>
                <p class="t-cuerpo-grande mt-5 max-w-[30rem] text-texto-secundario">Dejanos tus datos y te escribimos para coordinar una demo según cómo trabaja tu taller.</p>

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
                    <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="enlace mt-2 inline-flex items-center gap-2">
                        <x-icon name="whatsapp" class="h-5 w-5" />
                        Escribinos por WhatsApp
                    </a>
                </div>
            </div>

            <div class="tarjeta !p-6 shadow-2 sm:!p-8">
                <h2 class="t-titulo-2">Tus datos</h2>
                <p class="t-cuerpo-chico mt-1 text-texto-secundario">Todos los campos son obligatorios, salvo los que dicen "opcional".</p>

                @if ($errors->any())
                    <div class="aviso aviso-error mt-6" role="alert">
                        <x-icon name="alert-circle" class="h-5 w-5 shrink-0" />
                        <p><span class="font-medium">Revisá los campos marcados.</span> Hay datos que faltan o no son válidos.</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('contacto.store') }}" class="mt-6 space-y-5">
                    @csrf
                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <label for="website">No completes este campo</label>
                        <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        @foreach ($fields as $field)
                            <div>
                                <label for="{{ $field['id'] }}" class="rotulo">{{ $field['label'] }}</label>
                                <input id="{{ $field['id'] }}"
                                       name="{{ $field['id'] }}"
                                       type="{{ $field['type'] }}"
                                       value="{{ old($field['id']) }}"
                                       autocomplete="{{ $field['autocomplete'] }}"
                                       maxlength="{{ $field['max'] }}"
                                       placeholder="{{ $field['placeholder'] }}"
                                       @if ($field['type'] === 'tel') inputmode="tel" @endif
                                       @error($field['id']) aria-invalid="true" aria-describedby="{{ $field['id'] }}-error" @enderror
                                       required
                                       class="campo">
                                @error($field['id']) <p id="{{ $field['id'] }}-error" class="error-campo">{{ $message }}</p> @enderror
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <label for="message" class="rotulo">¿Qué te gustaría ordenar primero? <span class="font-normal text-texto-secundario">(opcional)</span></label>
                        <textarea id="message" name="message" rows="3" maxlength="2000" class="campo resize-y" placeholder="Por ejemplo: las órdenes, la caja o las sucursales" @error('message') aria-invalid="true" aria-describedby="message-error" @enderror>{{ old('message') }}</textarea>
                        @error('message') <p id="message-error" class="error-campo">{{ $message }}</p> @enderror
                    </div>

                    <label for="marketing_opt_in" class="t-cuerpo-chico flex cursor-pointer items-start gap-3 rounded-md bg-gris-50 p-4">
                        <input id="marketing_opt_in" name="marketing_opt_in" value="1" type="checkbox" @checked(old('marketing_opt_in')) class="mt-0.5 h-5 w-5 shrink-0 accent-azul-800">
                        <span>También quiero recibir la guía mensual y novedades de IntegraTaller (opcional). Voy a confirmar mi email y me puedo dar de baja cuando quiera.</span>
                    </label>

                    <p class="t-cuerpo-chico text-texto-secundario">Usamos tus datos solo para responder esta solicitud. Leé la <a href="{{ route('privacidad') }}" class="enlace">política de privacidad</a>.</p>
                    <button type="submit" class="boton boton-principal w-full sm:w-auto" data-cta="demo">Pedí tu demo</button>
                </form>
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

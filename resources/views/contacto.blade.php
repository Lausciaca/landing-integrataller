@extends('layouts.app')

@section('title', 'Solicitá una demo de IntegraTaller')
@section('meta_description', 'Contanos sobre tu taller y coordinamos una demo de IntegraTaller para que conozcas sus funciones.')
@section('canonical', route('contacto'))

@php
    $whatsapp = 'https://wa.me/' . config('landing.whatsapp') . '?text=' . rawurlencode('Hola, quiero conocer IntegraTaller para mi taller.');
@endphp

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page grid gap-10 py-12 md:grid-cols-[0.9fr_1.1fr] md:gap-16 md:py-16">
            <div class="max-w-xl">
                <p class="section-kicker">Conocé el sistema</p>
                <h1 class="display-title mt-5 max-w-[9ch]">Veamos cómo funciona en tu taller.</h1>
                <p class="mt-6 max-w-[48ch] text-lg leading-relaxed text-secondary/75">Dejanos tus datos. El equipo se va a comunicar para coordinar una demo y entender qué necesita tu operación.</p>
                <div class="mt-8 border-t-2 border-secondary pt-5">
                    <p class="font-display text-2xl font-semibold">¿Preferís escribir primero?</p>
                    <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="mt-3 inline-flex items-center gap-2 font-bold text-primary underline decoration-primary/30 underline-offset-4 hover:decoration-primary">
                        <x-icon name="whatsapp" class="h-5 w-5" />
                        Consultanos por WhatsApp
                    </a>
                </div>
            </div>

            <div class="rounded-sm bg-white p-5 shadow-[0_14px_40px_rgba(37,50,58,0.08)] sm:p-8">
                <h2 class="font-display text-3xl font-semibold sm:text-4xl">Solicitar una demo</h2>
                <p class="mt-2 text-sm text-secondary/70">Los campos marcados con * son necesarios para coordinar.</p>

                <form method="POST" action="{{ route('contacto.store') }}" class="mt-6 space-y-4">
                    @csrf
                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <label for="website">No completes este campo</label>
                        <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-bold">Tu nombre *</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" maxlength="120" required class="input @error('name') border-danger @enderror" placeholder="Nombre y apellido">
                            @error('name') <p class="mt-1 text-sm text-danger" role="alert">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="taller" class="mb-1.5 block text-sm font-bold">Nombre del taller *</label>
                            <input id="taller" name="taller" type="text" value="{{ old('taller') }}" autocomplete="organization" maxlength="120" required class="input @error('taller') border-danger @enderror" placeholder="Tu taller">
                            @error('taller') <p class="mt-1 text-sm text-danger" role="alert">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-bold">Email *</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="254" required class="input @error('email') border-danger @enderror" placeholder="nombre@taller.com">
                            @error('email') <p class="mt-1 text-sm text-danger" role="alert">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phone" class="mb-1.5 block text-sm font-bold">WhatsApp o celular *</label>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" inputmode="tel" maxlength="40" required class="input @error('phone') border-danger @enderror" placeholder="Código de área + número">
                            @error('phone') <p class="mt-1 text-sm text-danger" role="alert">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="message" class="mb-1.5 block text-sm font-bold">¿Qué te gustaría ordenar primero? <span class="font-normal text-secondary/65">(opcional)</span></label>
                        <textarea id="message" name="message" rows="3" maxlength="2000" class="input resize-y @error('message') border-danger @enderror" placeholder="Por ejemplo: órdenes de trabajo, stock o turnos">{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1 text-sm text-danger" role="alert">{{ $message }}</p> @enderror
                    </div>

                    <div class="rounded-sm bg-neutral p-4">
                        <label for="marketing_opt_in" class="flex cursor-pointer items-start gap-3 text-sm leading-relaxed text-secondary/80">
                            <input id="marketing_opt_in" name="marketing_opt_in" value="1" type="checkbox" @checked(old('marketing_opt_in')) class="mt-1 h-4 w-4 shrink-0 accent-primary">
                            <span>También quiero recibir guías prácticas y novedades mensuales de IntegraTaller. Voy a confirmar mi email y podré darme de baja cuando quiera.</span>
                        </label>
                    </div>

                    <p class="text-xs leading-relaxed text-secondary/65">Usaremos tus datos para responder esta solicitud. La suscripción a novedades es opcional. Leé nuestra <a href="{{ route('privacidad') }}" class="font-bold text-primary underline underline-offset-2">política de privacidad</a>.</p>
                    <button type="submit" class="btn btn-primary w-full sm:w-auto" data-cta="demo">Solicitar una demo</button>
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
            'name' => 'Solicitar una demo — IntegraTaller',
            'url' => route('contacto'),
            'inLanguage' => 'es-AR',
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

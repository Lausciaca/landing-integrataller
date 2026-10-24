@extends('layouts.app')

@section('title', 'Recibimos tu pedido | IntegraTaller')
@section('meta_description', 'Recibimos tu pedido de demo de IntegraTaller.')
@section('robots', 'noindex, nofollow')

@php
    // Mensaje listo para que el lead confirme por WhatsApp (sin datos de la sesión, el mensaje de siempre).
    $lead = session('lead');
    $whatsappMessage = null;
    if (is_array($lead) && filled($lead['name'] ?? null)) {
        $branches = match ($lead['branches'] ?? null) {
            '1' => 'Tengo 1 sucursal.',
            '2', '3' => 'Tengo '.$lead['branches'].' sucursales.',
            '4+' => 'Tengo 4 o más sucursales.',
            default => null,
        };
        $whatsappMessage = trim('Hola, soy '.$lead['name'].'. Acabo de pedir una demo de IntegraTaller. '.$branches);
    }
    $bookingUrl = config('landing.booking_url');
@endphp

@section('content')
    <x-resultado eyebrow="Pedido recibido" title="Gracias por contarnos sobre tu taller." icon="check" tone="exito">
        <p class="t-cuerpo-grande mt-4 text-texto-secundario">Confirmá tu demo por WhatsApp y te respondemos ahí mismo.</p>
        <p class="mt-2 flex items-start gap-2 font-medium text-azul-800">
            <x-icon name="clock" class="mt-0.5 h-5 w-5 shrink-0 text-celeste-700" />
            {{-- TODO-CONFIRMAR: texto en config/landing.php (copy.response_time_text) --}}
            <span>{{ config('landing.copy.response_time_text') }}</span>
        </p>

        @if (session('newsletter_result') === 'confirmation_sent')
            <div class="aviso aviso-info mt-6"><x-icon name="mail" class="h-5 w-5 shrink-0" /><p><span class="font-medium">Revisá tu correo.</span> Te mandamos un enlace para confirmar la guía mensual. La demo no depende de esa confirmación.</p></div>
        @elseif (session('newsletter_result') === 'already_subscribed')
            <div class="aviso aviso-info mt-6"><x-icon name="mail" class="h-5 w-5 shrink-0" /><p><span class="font-medium">Ya estabas suscripto a la guía mensual.</span> El pedido de demo se recibió por separado.</p></div>
        @elseif (session('newsletter_result') === 'email_failed')
            <div class="aviso aviso-alerta mt-6"><x-icon name="alert-circle" class="h-5 w-5 shrink-0" /><p><span class="font-medium">No pudimos mandar el correo de la guía mensual.</span> El pedido de demo sí se recibió. Podés suscribirte más tarde desde la página de guías.</p></div>
        @endif

        <div class="mt-8 flex flex-col gap-3">
            <a href="{{ \App\Support\WhatsApp::url($whatsappMessage) }}" target="_blank" rel="noopener noreferrer" class="boton boton-principal w-full !min-h-14 text-[16px]" data-cta="confirmar-whatsapp">
                <x-icon name="whatsapp" class="h-5 w-5" />
                Abrir WhatsApp y confirmar mi demo
            </a>
            @if (filled($bookingUrl))
                <a href="{{ $bookingUrl }}" target="_blank" rel="noopener noreferrer" class="boton boton-secundario w-full" data-cta="agenda">
                    <x-icon name="calendar" class="h-5 w-5" />
                    Elegí el horario de tu demo
                </a>
            @endif
        </div>

        <div class="mt-8 rounded-md bg-azul-50 p-5">
            <p class="font-medium text-azul-800">Mientras tanto, podés probarlo ya: 1 mes gratis.</p>
            <p class="t-cuerpo-chico mt-1 text-texto-secundario">Te registrás con tu cuenta de Google, sin tarjeta, y empezás a cargar tus órdenes hoy.</p>
            <a href="{{ \App\Support\Saas::signupUrl() }}" class="boton boton-terciario mt-2 !px-0" data-cta="registro" data-registro>
                Probá 1 mes gratis
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>

        <p class="mt-8"><a href="{{ route('home') }}" class="enlace">Volver al inicio</a></p>
    </x-resultado>
@endsection

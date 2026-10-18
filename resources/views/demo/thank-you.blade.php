@extends('layouts.app')

@section('title', 'Recibimos tu pedido | IntegraTaller')
@section('meta_description', 'Recibimos tu pedido de demo de IntegraTaller.')
@section('robots', 'noindex, nofollow')

@section('content')
    <x-resultado eyebrow="Pedido recibido" title="Gracias por contarnos sobre tu taller." icon="check" tone="exito">
        <p class="t-cuerpo-grande mt-4 text-texto-secundario">Te vamos a escribir para coordinar la demo de IntegraTaller.</p>

        @if (session('newsletter_result') === 'confirmation_sent')
            <div class="aviso aviso-info mt-6"><x-icon name="mail" class="h-5 w-5 shrink-0" /><p><span class="font-medium">Revisá tu correo.</span> Te mandamos un enlace para confirmar la guía mensual. La demo no depende de esa confirmación.</p></div>
        @elseif (session('newsletter_result') === 'already_subscribed')
            <div class="aviso aviso-info mt-6"><x-icon name="mail" class="h-5 w-5 shrink-0" /><p><span class="font-medium">Ya estabas suscripto a la guía mensual.</span> El pedido de demo se recibió por separado.</p></div>
        @elseif (session('newsletter_result') === 'email_failed')
            <div class="aviso aviso-alerta mt-6"><x-icon name="alert-circle" class="h-5 w-5 shrink-0" /><p><span class="font-medium">No pudimos mandar el correo de la guía mensual.</span> El pedido de demo sí se recibió. Podés suscribirte más tarde desde la página de guías.</p></div>
        @endif

        <a href="{{ route('home') }}" class="boton boton-secundario mt-8">Volver al inicio</a>
    </x-resultado>
@endsection

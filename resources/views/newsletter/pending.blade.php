@extends('layouts.app')

@section('title', 'Confirmá tu suscripción | IntegraTaller')
@section('robots', 'noindex, nofollow')

@section('content')
    @if (session('newsletter_result') === 'already_subscribed')
        <x-resultado eyebrow="Guía mensual" title="Ese email ya está suscripto." icon="check" tone="exito">
            <p class="t-cuerpo-grande mt-4 text-texto-secundario">Vas a seguir recibiendo el email mensual. Podés darte de baja desde el enlace que aparece en cada correo.</p>
            <a href="{{ route('home') }}" class="boton boton-secundario mt-8">Volver al inicio</a>
        </x-resultado>
    @elseif (session('newsletter_result') === 'email_failed')
        <x-resultado eyebrow="Guía mensual" title="No pudimos mandar el correo." icon="alert-circle" tone="neutro">
            <p class="t-cuerpo-grande mt-4 text-texto-secundario">La suscripción todavía no está activa. Revisá tu dirección y probá de nuevo.</p>
            <a href="{{ route('tutoriales') }}#newsletter" class="boton boton-principal mt-8">Probar de nuevo</a>
        </x-resultado>
    @else
        <x-resultado eyebrow="Un paso más" title="Revisá tu correo para confirmar." icon="mail">
            <p class="t-cuerpo-grande mt-4 text-texto-secundario">Te mandamos un enlace de confirmación. La suscripción se activa cuando confirmes tu dirección.</p>
            <p class="t-cuerpo-chico mt-3 text-texto-secundario">Si no lo ves, revisá la carpeta de correo no deseado.</p>
            <a href="{{ route('home') }}" class="boton boton-secundario mt-8">Volver al inicio</a>
        </x-resultado>
    @endif
@endsection

@extends('layouts.app')

@section('title', 'Confirmar suscripción | IntegraTaller')
@section('robots', 'noindex, nofollow')

@section('content')
    @if ($valid)
        <x-resultado eyebrow="Confirmación de email" title="¿Querés recibir la guía mensual?" icon="mail">
            <p class="t-cuerpo-grande mt-4 text-texto-secundario">Te va a llegar un email por mes con guías prácticas y novedades de IntegraTaller. Podés darte de baja cuando quieras.</p>
            <form method="POST" action="{{ route('newsletter.confirm') }}" class="mt-8">
                @csrf
                <input type="hidden" name="confirmation_token" value="{{ $token }}">
                <button type="submit" class="boton boton-principal">Confirmar suscripción</button>
            </form>
        </x-resultado>
    @else
        <x-resultado eyebrow="Enlace no disponible" title="Este enlace ya venció o ya se usó." icon="alert-circle" tone="neutro">
            <p class="t-cuerpo-grande mt-4 text-texto-secundario">Suscribite de nuevo y te mandamos otro correo de confirmación.</p>
            <a href="{{ route('tutoriales') }}#newsletter" class="boton boton-principal mt-8">Volver a suscribirme</a>
        </x-resultado>
    @endif
@endsection

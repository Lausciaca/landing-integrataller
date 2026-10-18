@extends('layouts.app')

@section('title', 'Preferencias de email | IntegraTaller')
@section('robots', 'noindex, nofollow')

@section('content')
    @if ($valid)
        <x-resultado eyebrow="Preferencias de email" title="¿Querés dejar de recibir estos correos?" icon="mail" tone="neutro">
            <p class="t-cuerpo-grande mt-4 text-texto-secundario">La baja es inmediata. Si cambiás de opinión, te podés volver a suscribir.</p>
            <form method="POST" action="{{ route('newsletter.unsubscribe') }}" class="mt-8 flex flex-col gap-3 sm:flex-row">
                @csrf
                <input type="hidden" name="unsubscribe_token" value="{{ $token }}">
                <button type="submit" class="boton boton-secundario">Dar de baja la suscripción</button>
                <a href="{{ route('home') }}" class="boton boton-terciario">Volver al inicio</a>
            </form>
        </x-resultado>
    @else
        <x-resultado eyebrow="Enlace no disponible" title="No encontramos una suscripción activa." icon="alert-circle" tone="neutro">
            <p class="t-cuerpo-grande mt-4 text-texto-secundario">El enlace puede haberse usado o ya no estar vigente.</p>
            <a href="{{ route('home') }}" class="boton boton-secundario mt-8">Volver al inicio</a>
        </x-resultado>
    @endif
@endsection

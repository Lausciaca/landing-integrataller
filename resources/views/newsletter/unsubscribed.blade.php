@extends('layouts.app')

@section('title', 'Preferencias actualizadas | IntegraTaller')
@section('robots', 'noindex, nofollow')

@section('content')
    @if ($unsubscribed)
        <x-resultado eyebrow="Preferencias actualizadas" title="Ya no vas a recibir emails mensuales." icon="check" tone="exito">
            <p class="t-cuerpo-grande mt-4 text-texto-secundario">La baja quedó registrada.</p>
            <a href="{{ route('home') }}" class="boton boton-secundario mt-8">Volver al inicio</a>
        </x-resultado>
    @else
        <x-resultado eyebrow="Enlace no disponible" title="No encontramos una suscripción activa." icon="alert-circle" tone="neutro">
            <a href="{{ route('home') }}" class="boton boton-secundario mt-8">Volver al inicio</a>
        </x-resultado>
    @endif
@endsection

@extends('layouts.app')

@section('title', $confirmed ? 'Suscripción confirmada | IntegraTaller' : 'Enlace no disponible | IntegraTaller')
@section('robots', 'noindex, nofollow')

@section('content')
    @if ($confirmed)
        <x-resultado eyebrow="Suscripción confirmada" title="Listo. Nos leemos pronto." icon="check" tone="exito">
            <p class="t-cuerpo-grande mt-4 text-texto-secundario">Te va a llegar un email por mes con guías prácticas y novedades de IntegraTaller.</p>
            <a href="{{ route('home') }}" class="boton boton-secundario mt-8">Volver al inicio</a>
        </x-resultado>
    @else
        <x-resultado eyebrow="Enlace no disponible" title="No pudimos confirmar esa dirección." icon="alert-circle" tone="neutro">
            <p class="t-cuerpo-grande mt-4 text-texto-secundario">El enlace puede haber vencido o ya haberse usado.</p>
            <a href="{{ route('home') }}" class="boton boton-secundario mt-8">Volver al inicio</a>
        </x-resultado>
    @endif
@endsection

@extends('layouts.app')

@section('title', 'Preferencias actualizadas | IntegraTaller')
@section('robots', 'noindex, nofollow')

@section('content')
    <section class="min-h-[65vh] bg-neutral">
        <div class="container-page flex min-h-[65vh] max-w-2xl flex-col justify-center py-16">
            @if ($unsubscribed)
                <p class="section-kicker">Preferencias actualizadas</p>
                <h1 class="mt-4 font-display text-5xl font-semibold leading-none sm:text-6xl">Ya no vas a recibir emails mensuales.</h1>
                <p class="mt-5 max-w-[50ch] leading-relaxed text-secondary/75">La solicitud de baja quedó registrada.</p>
            @else
                <p class="section-kicker">Enlace no disponible</p>
                <h1 class="mt-4 font-display text-5xl font-semibold leading-none sm:text-6xl">No encontramos una suscripción activa.</h1>
            @endif
            <a href="{{ route('home') }}" class="btn btn-primary mt-7 self-start">Volver al inicio</a>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('title', 'Preferencias de email | IntegraTaller')
@section('robots', 'noindex, nofollow')

@section('content')
    <section class="min-h-[65vh] bg-neutral">
        <div class="container-page flex min-h-[65vh] max-w-2xl flex-col justify-center py-16">
            @if ($valid)
                <p class="section-kicker">Preferencias de email</p>
                <h1 class="mt-4 font-display text-5xl font-semibold leading-none sm:text-6xl">¿Querés dejar de recibir estos correos?</h1>
                <p class="mt-5 max-w-[50ch] leading-relaxed text-secondary/75">La baja es inmediata. Vas a poder volver a suscribirte más adelante si cambiás de opinión.</p>
                <form method="POST" action="{{ route('newsletter.unsubscribe') }}" class="mt-7">
                    @csrf
                    <input type="hidden" name="unsubscribe_token" value="{{ $token }}">
                    <button type="submit" class="btn btn-secondary">Dar de baja la suscripción</button>
                </form>
            @else
                <p class="section-kicker">Enlace no disponible</p>
                <h1 class="mt-4 font-display text-5xl font-semibold leading-none sm:text-6xl">No encontramos una suscripción activa.</h1>
                <p class="mt-5 max-w-[50ch] leading-relaxed text-secondary/75">El enlace puede haber sido usado o ya no estar vigente.</p>
            @endif
            <a href="{{ route('home') }}" class="mt-7 font-bold text-primary underline underline-offset-4">Volver al inicio</a>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('title', 'Confirmar suscripción | IntegraTaller')
@section('robots', 'noindex, nofollow')

@section('content')
    <section class="min-h-[65vh] bg-neutral">
        <div class="container-page flex min-h-[65vh] max-w-2xl flex-col justify-center py-16">
            @if ($valid)
                <p class="section-kicker">Confirmación de email</p>
                <h1 class="mt-4 font-display text-5xl font-semibold leading-none sm:text-6xl">¿Querés recibir las guías mensuales?</h1>
                <p class="mt-5 max-w-[52ch] leading-relaxed text-secondary/75">Al confirmar, vas a recibir un correo mensual con guías prácticas y novedades de IntegraTaller. Podés darte de baja cuando quieras.</p>
                <form method="POST" action="{{ route('newsletter.confirm') }}" class="mt-7">
                    @csrf
                    <input type="hidden" name="confirmation_token" value="{{ $token }}">
                    <button type="submit" class="btn btn-primary">Confirmar suscripción</button>
                </form>
            @else
                <p class="section-kicker">Enlace no disponible</p>
                <h1 class="mt-4 font-display text-5xl font-semibold leading-none sm:text-6xl">Este enlace ya venció o fue usado.</h1>
                <p class="mt-5 max-w-[52ch] leading-relaxed text-secondary/75">Volvé a suscribirte y te mandamos un nuevo correo de confirmación.</p>
                <a href="{{ route('tutoriales') }}" class="btn btn-primary mt-7 self-start">Volver a las guías</a>
            @endif
        </div>
    </section>
@endsection

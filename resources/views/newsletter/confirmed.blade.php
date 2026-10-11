@extends('layouts.app')

@section('title', $confirmed ? 'Suscripción confirmada | IntegraTaller' : 'Enlace no disponible | IntegraTaller')
@section('robots', 'noindex, nofollow')

@section('content')
    <section class="min-h-[65vh] bg-neutral">
        <div class="container-page flex min-h-[65vh] max-w-2xl flex-col justify-center py-16">
            @if ($confirmed)
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-surface text-white"><x-icon name="check" class="h-6 w-6" /></span>
                <p class="section-kicker mt-6">Suscripción confirmada</p>
                <h1 class="mt-4 font-display text-5xl font-semibold leading-none sm:text-6xl">Listo. Nos leemos pronto.</h1>
                <p class="mt-5 max-w-[50ch] leading-relaxed text-secondary/75">Vas a recibir un correo mensual con guías prácticas y novedades de IntegraTaller.</p>
            @else
                <p class="section-kicker">Enlace no disponible</p>
                <h1 class="mt-4 font-display text-5xl font-semibold leading-none sm:text-6xl">No pudimos confirmar esa dirección.</h1>
                <p class="mt-5 max-w-[50ch] leading-relaxed text-secondary/75">El enlace puede haber vencido o ya haber sido utilizado.</p>
            @endif
            <a href="{{ route('home') }}" class="btn btn-primary mt-7 self-start">Volver al inicio</a>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('title', 'Confirmá tu suscripción | IntegraTaller')
@section('robots', 'noindex, nofollow')

@section('content')
    <section class="min-h-[65vh] bg-neutral">
        <div class="container-page flex min-h-[65vh] max-w-2xl flex-col justify-center py-16">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-accent/25 text-primary"><x-icon name="mail" class="h-6 w-6" /></span>
            <p class="section-kicker mt-6">Un paso más</p>
            @if (session('newsletter_result') === 'already_subscribed')
                <h1 class="mt-4 font-display text-5xl font-semibold leading-none sm:text-6xl">Ese email ya está suscripto.</h1>
                <p class="mt-5 max-w-[50ch] leading-relaxed text-secondary/75">Vas a seguir recibiendo el correo mensual. Podés darte de baja desde el enlace que aparece en los emails.</p>
            @elseif (session('newsletter_result') === 'email_failed')
                <h1 class="mt-4 font-display text-5xl font-semibold leading-none sm:text-6xl">No pudimos enviar el correo.</h1>
                <p class="mt-5 max-w-[50ch] leading-relaxed text-secondary/75">La suscripción todavía no está activa. Revisá tu dirección y volvé a intentarlo desde el formulario.</p>
                <a href="{{ route('tutoriales') }}" class="btn btn-primary mt-7 self-start">Volver a las guías</a>
            @else
                <h1 class="mt-4 font-display text-5xl font-semibold leading-none sm:text-6xl">Revisá tu correo para confirmar.</h1>
                <p class="mt-5 max-w-[50ch] leading-relaxed text-secondary/75">Te enviamos un enlace de confirmación. La suscripción mensual se activa cuando confirmes tu dirección.</p>
                <p class="mt-3 text-sm text-secondary/65">Si no lo ves, revisá la carpeta de correo no deseado.</p>
            @endif
            <a href="{{ route('home') }}" class="mt-7 font-bold text-primary underline underline-offset-4">Volver al inicio</a>
        </div>
    </section>
@endsection

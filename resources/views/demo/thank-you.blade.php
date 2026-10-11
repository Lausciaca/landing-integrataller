@extends('layouts.app')

@section('title', 'Recibimos tu solicitud | IntegraTaller')
@section('meta_description', 'Recibimos tu pedido de demo de IntegraTaller.')
@section('robots', 'noindex, nofollow')

@section('content')
    <section class="min-h-[65vh] bg-neutral">
        <div class="container-page flex min-h-[65vh] max-w-3xl flex-col justify-center py-16">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-surface text-white"><x-icon name="check" class="h-6 w-6" /></span>
            <p class="section-kicker mt-6">Solicitud recibida</p>
            <h1 class="mt-4 font-display text-5xl font-semibold leading-none sm:text-6xl">Gracias por contarnos sobre tu taller.</h1>
            <p class="mt-5 max-w-[55ch] text-lg leading-relaxed text-secondary/75">El equipo va a usar los datos que compartiste para coordinar una demo de IntegraTaller.</p>

            @if (session('newsletter_result') === 'confirmation_sent')
                <p class="mt-5 max-w-[55ch] rounded-sm border-l-4 border-accent bg-white p-4 text-sm leading-relaxed">También te enviamos un correo para confirmar la suscripción mensual. La demo no depende de esa confirmación.</p>
            @elseif (session('newsletter_result') === 'already_subscribed')
                <p class="mt-5 max-w-[55ch] rounded-sm border-l-4 border-surface bg-white p-4 text-sm leading-relaxed">El email ya estaba suscripto. La solicitud de demo se recibió por separado.</p>
            @elseif (session('newsletter_result') === 'email_failed')
                <p class="mt-5 max-w-[55ch] rounded-sm border-l-4 border-accent bg-white p-4 text-sm leading-relaxed">La solicitud de demo se recibió. No pudimos enviar el correo de confirmación de novedades; podés suscribirte más tarde desde la página de guías.</p>
            @endif

            <a href="{{ route('home') }}" class="btn btn-primary mt-8 self-start">Volver al inicio</a>
        </div>
    </section>
@endsection

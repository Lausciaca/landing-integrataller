@extends('layouts.app')

@section('title', 'Software para talleres mecánicos por ciudad | IntegraTaller')
@section('meta_description', 'Conocé IntegraTaller: software de gestión para talleres mecánicos de Rosario, Córdoba, Buenos Aires y otras ciudades.')
@section('canonical', route('cities.index'))

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <p class="section-kicker">Talleres de Argentina</p>
            <h1 class="display-title mt-5 max-w-[12ch]">Una forma más clara de organizar el taller.</h1>
            <p class="mt-6 max-w-[58ch] text-lg leading-relaxed text-secondary/75">Conocé cómo IntegraTaller ayuda a gestionar el trabajo en tu ciudad.</p>
        </div>
    </section>

    <section class="bg-white">
        <div class="container-page section-gap">
            <div class="grid gap-x-10 border-t-2 border-secondary sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($cities as $slug => $city)
                    <a href="{{ route('cities.show', $slug) }}" class="group border-b border-line py-6">
                        <p class="text-sm font-bold text-primary">{{ $city['province'] }}</p>
                        <h2 class="mt-2 font-display text-3xl font-semibold group-hover:text-primary">Talleres en {{ $city['name'] }}</h2>
                        <p class="mt-3 text-sm leading-relaxed text-secondary/70">{{ $city['meta_description'] }}</p>
                        <span class="mt-4 inline-flex font-bold text-primary underline decoration-primary/30 underline-offset-4 group-hover:decoration-primary">Ver información</span>
                    </a>
                @endforeach
            </div>
            <a href="{{ route('contacto') }}" class="btn btn-primary mt-9" data-cta="demo">Solicitar una demo</a>
        </div>
    </section>
@endsection

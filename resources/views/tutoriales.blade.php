@extends('layouts.app')

@section('title', 'Tutoriales: cómo usar el software de taller | IntegraTaller')
@section('meta_description', 'Aprendé a configurar tu taller, cargar patentes, abrir órdenes de trabajo y controlar el stock. Guías paso a paso y soporte por tickets.')

@php
    $waBase = 'https://wa.me/' . config('landing.whatsapp') . '?text=';

    $categories = [
        [
            'icon' => 'settings',
            'title' => 'Primeros Pasos',
            'text' => 'Configurar los datos del taller y métodos de pago.',
        ],
        [
            'icon' => 'car',
            'title' => 'Clientes y Vehículos',
            'text' => 'Cómo dar de alta una patente y revisar historiales.',
        ],
        [
            'icon' => 'receipt',
            'title' => 'Órdenes y Presupuestos',
            'text' => 'Cómo abrir una orden de trabajo y enviarla al cliente.',
        ],
        [
            'icon' => 'package',
            'title' => 'Inventario',
            'text' => 'Cómo cargar el stock inicial de repuestos.',
        ],
    ];
@endphp

@section('content')
    {{-- CABECERA CON BUSCADOR --}}
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-bold uppercase tracking-[0.14em] text-primary">Base de conocimiento</p>
                <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">Tutoriales de IntegraTaller</h1>
                <p class="mt-4 text-lg leading-relaxed text-secondary/70">
                    Buscá una guía o explorá por categoría. Todo explicado simple, para hacerlo desde el taller.
                </p>
            </div>

            <form class="mx-auto mt-8 max-w-2xl" role="search" id="form-busqueda">
                <label for="buscador-tutoriales" class="sr-only">Buscar tutoriales</label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-secondary/70">
                        <x-icon name="search" class="h-6 w-6" />
                    </span>
                    <input id="buscador-tutoriales"
                           type="search"
                           autocomplete="off"
                           placeholder="Ej: Cómo cargar un turno nuevo"
                           class="input h-16 rounded-md pl-14 pr-4 text-lg"
                           style="box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                </div>
            </form>
        </div>
    </section>

    {{-- GRILLA DE CATEGORÍAS --}}
    <section class="border-b border-line bg-white">
        <div class="container-page section-gap">
            <h2 class="text-2xl font-bold tracking-tight">Explorá por categoría</h2>

            <div id="grilla-categorias" class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($categories as $category)
                    <a href="{{ $waBase . rawurlencode('Hola! Necesito ayuda con "' . $category['title'] . '" en IntegraTaller.') }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="reveal card group flex flex-col transition duration-200 hover:-translate-y-1 hover:border-primary/40"
                       data-delay="{{ $loop->index }}"
                       data-category="{{ $category['title'] }} {{ $category['text'] }}">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-sm bg-primary/10 text-primary">
                            <x-icon :name="$category['icon']" class="h-6 w-6" />
                        </span>
                        <h3 class="mt-4 text-lg font-bold">{{ $category['title'] }}</h3>
                        <p class="mt-2 flex-1 text-sm leading-relaxed text-secondary/70">{{ $category['text'] }}</p>
                        <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                            Consultar
                            <x-icon name="chevron-right" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5" />
                        </span>
                    </a>
                @endforeach
            </div>

            <p id="sin-resultados" class="hidden py-10 text-center text-secondary/70">
                No encontramos tutoriales con ese término. Probá con otra palabra.
            </p>

            {{-- AVISO INFERIOR --}}
            <div class="mt-12 flex flex-col items-start gap-4 rounded-lg border border-line bg-neutral p-6 sm:flex-row sm:items-center">
                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-sm bg-secondary text-white">
                    <x-icon name="ticket" class="h-5 w-5" />
                </span>
                <p class="text-secondary/80">
                    Si ya sos cliente y tenés un problema técnico, abrí un ticket desde tu panel de administración
                    para atención prioritaria.
                </p>
                <a href="{{ route('contacto') }}" class="btn btn-ghost shrink-0 sm:ml-auto">Ir a contacto</a>
            </div>
        </div>
    </section>
@endsection

@push('head')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Tutoriales de IntegraTaller',
            'url' => route('tutoriales'),
            'inLanguage' => 'es-AR',
            'hasPart' => collect($categories)->map(fn ($category) => [
                '@type' => 'HowTo',
                'name' => $category['title'],
                'description' => $category['text'],
            ])->all(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

@push('scripts')
    <script>
        (function () {
            var form = document.getElementById('form-busqueda');
            var input = document.getElementById('buscador-tutoriales');
            var grid = document.getElementById('grilla-categorias');
            var empty = document.getElementById('sin-resultados');
            if (!input || !grid || !empty) return;

            if (form) {
                form.addEventListener('submit', function (e) { e.preventDefault(); });
            }

            var cards = Array.prototype.slice.call(grid.querySelectorAll('[data-category]'));

            input.addEventListener('input', function () {
                var term = input.value.trim().toLowerCase();
                var visible = 0;

                cards.forEach(function (card) {
                    var match = card.getAttribute('data-category').toLowerCase().indexOf(term) !== -1;
                    card.classList.toggle('hidden', !match);
                    if (match) visible++;
                });

                empty.classList.toggle('hidden', visible !== 0);
            });
        })();
    </script>
@endpush

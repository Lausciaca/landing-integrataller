{{-- Pantalla simple de resultado (gracias, confirmaciones, bajas). --}}
@props(['eyebrow' => null, 'title', 'icon' => null, 'tone' => 'info'])

@php
    $tones = [
        'exito' => 'bg-exito-fondo text-exito',
        'info' => 'bg-info-fondo text-info',
        'neutro' => 'bg-neutro-fondo text-neutro',
    ];
@endphp

<section class="bg-gris-50">
    <div class="contenedor flex min-h-[60vh] items-center py-16">
        <div class="tarjeta w-full max-w-[640px] !p-8 sm:!p-10">
            @if ($icon)
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-full {{ $tones[$tone] ?? $tones['info'] }}">
                    <x-icon :name="$icon" class="h-6 w-6" />
                </span>
            @endif
            @if ($eyebrow)
                <p class="t-etiqueta {{ $icon ? 'mt-6' : '' }}">{{ $eyebrow }}</p>
            @endif
            <h1 class="t-titulo-1 mt-3">{{ $title }}</h1>
            {{ $slot }}
        </div>
    </div>
</section>

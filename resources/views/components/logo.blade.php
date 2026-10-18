{{-- Logo oficial de IntegraTaller (archivos del manual de marca, public/brand). No aplicar filtros ni recolorear. --}}
@props(['variant' => 'horizontal', 'class' => 'h-9'])

@php
    $files = [
        'horizontal' => ['brand/logo-horizontal-color.svg', 860, 168],
        'negativo' => ['brand/logo-horizontal-negativo.svg', 860, 168],
        'isotipo' => ['brand/isotipo-color.svg', 200, 200],
        'isotipo-negativo' => ['brand/isotipo-negativo.svg', 200, 200],
    ];
    [$file, $width, $height] = $files[$variant] ?? $files['horizontal'];
@endphp

<img src="{{ asset($file) }}"
     alt="IntegraTaller"
     width="{{ $width }}" height="{{ $height }}"
     decoding="async"
     {{ $attributes->merge(['class' => $class . ' w-auto']) }}>

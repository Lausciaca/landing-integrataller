@props([
    'eyebrow' => null,
    'title' => null,
    'subtitle' => null,
    'align' => 'left',
    'level' => 'h2',
    'id' => null,
])

@php
    $tag = in_array($level, ['h1', 'h2', 'h3'], true) ? $level : 'h2';
@endphp

<div {{ $attributes->class([
    'max-w-[680px]',
    'mx-auto text-center' => $align === 'center',
]) }}>
    @if ($eyebrow)
        <p class="t-etiqueta">{{ $eyebrow }}</p>
    @endif

    @if ($title)
        <{{ $tag }} @if ($id) id="{{ $id }}" @endif class="{{ $tag === 'h1' ? 't-display' : 't-titulo-1' }} mt-3">{{ $title }}</{{ $tag }}>
    @endif

    @if ($subtitle)
        <p class="t-cuerpo-grande mt-4 text-texto-secundario">{{ $subtitle }}</p>
    @endif
</div>

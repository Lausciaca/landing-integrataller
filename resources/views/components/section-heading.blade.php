@props([
    'eyebrow' => null,
    'title' => null,
    'subtitle' => null,
    'align' => 'center',
    'level' => 'h2',
])

@php
    $tag = in_array($level, ['h1', 'h2', 'h3'], true) ? $level : 'h2';
@endphp

<div @class([
    'max-w-3xl',
    'mx-auto text-center' => $align === 'center',
    'text-left' => $align === 'left',
])>
    @if ($eyebrow)
        <p class="text-sm font-bold uppercase tracking-[0.14em] text-primary">{{ $eyebrow }}</p>
    @endif

    @if ($title)
        <{{ $tag }} class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">{{ $title }}</{{ $tag }}>
    @endif

    @if ($subtitle)
        <p class="mt-4 text-lg leading-relaxed text-secondary/70">{{ $subtitle }}</p>
    @endif
</div>

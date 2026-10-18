{{-- Etiqueta de estado del manual: el color nunca va solo, siempre con su palabra. --}}
@props(['tipo' => 'neutro'])

<span {{ $attributes->merge(['class' => 'estado estado-' . $tipo]) }}>{{ $slot }}</span>

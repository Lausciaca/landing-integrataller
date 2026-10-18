{{--
    Recurso gráfico de la marca: el isotipo (arco con dientes y nodos conectados) ampliado.
    Las sucursales son los nodos. Con `etiquetas` se nombra cada nodo; sin ellas es decorativo.
    Colores por variables: --nodos-base (arco y dientes) y --nodos-acento (líneas y nodos).
--}}
@props(['etiquetas' => [], 'animado' => false])

@php
    $centro = [220, 240];
    $puntas = [[401, 142], [427, 240], [401, 338]];
    $dientes = [0, -45, -90, -135, 180];
@endphp

<svg {{ $attributes->class(['nodos-grafico', 'nodos-animado' => $animado]) }}
     viewBox="0 0 {{ $etiquetas ? 640 : 480 }} 480"
     @if ($etiquetas) role="img" aria-label="Todas tus sucursales conectadas en un solo sistema" @else aria-hidden="true" @endif>
    <path class="nodos-arco" d="M326.07 346.07 A150 150 0 1 1 326.07 133.93" pathLength="1" fill="none" stroke-width="57" />

    <g class="nodos-dientes">
        @foreach ($dientes as $angulo)
            <rect class="nodos-diente" style="--i: {{ $loop->index }}" x="191.5" y="23" width="57" height="52" rx="8" transform="rotate({{ $angulo }} 220 240)" />
        @endforeach
    </g>

    @foreach ($puntas as [$x, $y])
        <line class="nodos-linea" style="--i: {{ $loop->index }}" x1="{{ $centro[0] }}" y1="{{ $centro[1] }}" x2="{{ $x }}" y2="{{ $y }}" pathLength="1" stroke-width="21" stroke-linecap="round" />
    @endforeach

    <circle class="nodos-punto" style="--i: 0" cx="{{ $centro[0] }}" cy="{{ $centro[1] }}" r="44" />
    @foreach ($puntas as [$x, $y])
        <circle class="nodos-punto" style="--i: {{ $loop->iteration }}" cx="{{ $x }}" cy="{{ $y }}" r="28" />
    @endforeach

    @foreach ($etiquetas as $i => [$titulo, $detalle])
        @php [$x, $y] = $puntas[$i]; @endphp
        <g class="nodos-etiqueta" style="--i: {{ $i }}">
            <text x="{{ $x + 42 }}" y="{{ $y - 4 }}" class="nodos-titulo">@if (str_starts_with($titulo, 'Sucursal '))<tspan class="nodos-prefijo">Sucursal </tspan>{{ substr($titulo, 9) }}@else{{ $titulo }}@endif</text>
            <text x="{{ $x + 42 }}" y="{{ $y + 24 }}" class="nodos-detalle">{{ $detalle }}</text>
        </g>
    @endforeach
</svg>

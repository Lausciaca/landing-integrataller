@props(['items'])

<nav class="t-cuerpo-chico mb-8 text-texto-secundario" aria-label="Migas de pan">
    <ol class="flex flex-wrap items-center gap-2">
        @foreach ($items as $label => $url)
            <li class="flex items-center gap-2">
                @if ($url)
                    <a href="{{ $url }}" class="hover:text-azul-800 hover:underline">{{ $label }}</a>
                    <x-icon name="chevron-right" class="h-4 w-4" />
                @else
                    <span aria-current="page" class="text-texto">{{ $label }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

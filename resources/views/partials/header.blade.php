@php
    $links = [
        ['label' => 'Funciones', 'href' => route('servicios')],
        ['label' => 'Cómo funciona', 'href' => route('home') . '#como-funciona'],
        // Solo si la home muestra precios (los datos del SaaS o el respaldo).
        app(\App\Services\PlanesPublicos::class)->datos() ? ['label' => 'Precios', 'href' => route('home') . '#precios'] : null,
        ['label' => 'Guías', 'href' => route('tutoriales')],
    ];
    $links = array_filter($links);
@endphp

<header data-site-header class="sticky top-0 z-[100] border-b border-borde bg-white transition-shadow">
    <div class="contenedor flex h-16 items-center justify-between gap-4 md:h-[76px]">
        <a href="{{ route('home') }}" class="shrink-0" aria-label="IntegraTaller, ir al inicio">
            <x-logo class="hidden h-8 md:block" />
            <x-logo variant="isotipo" class="h-9 md:hidden" />
        </a>

        <nav class="hidden items-center gap-8 md:flex" aria-label="Principal">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" class="text-[15px] font-medium text-texto transition-colors hover:text-azul-800">{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2">
            {{-- Clientes actuales: entran al sistema. Discreto, para no competir con la demo --}}
            <a href="{{ \App\Support\Saas::loginUrl() }}" class="hidden px-3 text-[15px] font-medium text-texto-secundario transition-colors hover:text-azul-800 md:inline-flex" data-cta="ingresar">Ingresar</a>
            <a href="{{ route('contacto') }}" class="boton boton-principal !min-h-11 px-4 md:px-5" data-cta="demo">Pedí tu demo</a>

            <button type="button"
                    data-menu-toggle
                    aria-controls="menu-movil"
                    aria-expanded="false"
                    aria-label="Abrir menú"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-md text-azul-800 transition-colors hover:bg-gris-100 md:hidden">
                <x-icon name="menu" data-icon-open class="h-6 w-6" />
                <x-icon name="x" data-icon-close class="hidden h-6 w-6" />
            </button>
        </div>
    </div>

    <div id="menu-movil" data-menu-panel class="hidden border-t border-borde bg-white md:hidden">
        <nav class="contenedor flex flex-col py-3" aria-label="Móvil">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" class="rounded-md px-3 py-3 font-medium text-texto hover:bg-gris-100">{{ $link['label'] }}</a>
            @endforeach
            <a href="{{ route('contacto') }}" class="rounded-md px-3 py-3 font-medium text-texto hover:bg-gris-100" data-cta="demo">Pedí tu demo</a>
            <a href="{{ \App\Support\Saas::loginUrl() }}" class="mt-2 rounded-md border-t border-borde px-3 py-3 font-medium text-texto-secundario hover:bg-gris-100" data-cta="ingresar">Ingresar</a>
        </nav>
    </div>
</header>

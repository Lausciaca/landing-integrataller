@php
    $nav = [
        ['label' => 'Servicios', 'route' => 'servicios'],
        ['label' => 'Tutoriales', 'route' => 'tutoriales'],
        ['label' => 'Contacto', 'route' => 'contacto'],
    ];
    $cotizar = config('landing.app_url');
@endphp

<header data-site-header
        class="sticky top-0 z-[100] border-b border-transparent bg-white transition-shadow duration-200">
    <div class="container-page flex h-[4.25rem] items-center justify-between gap-4 md:h-20">
        <a href="{{ route('home') }}" class="shrink-0" aria-label="IntegraTaller — inicio">
            <x-logo class="hidden h-9 md:block" />
            <x-logo tone="mark" class="h-9 md:hidden" />
        </a>

        <nav class="hidden items-center gap-1 md:flex" aria-label="Principal">
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}"
                   @if (request()->routeIs($item['route'])) aria-current="page" @endif
                   @class(['nav-link', 'nav-link-active' => request()->routeIs($item['route'])])>{{ $item['label'] }}</a>
            @endforeach
        </nav>

        <div class="hidden md:block">
            <a href="{{ $cotizar }}" class="btn btn-primary" data-cta="cotizar">
                Cotizar mi sistema
            </a>
        </div>

        <button type="button"
                data-menu-toggle
                aria-controls="menu-movil"
                aria-expanded="false"
                aria-label="Abrir menú"
                class="inline-flex h-11 w-11 items-center justify-center rounded-sm border border-line text-secondary transition hover:bg-neutral md:hidden">
            <x-icon name="menu" data-icon-open class="h-6 w-6" />
            <x-icon name="x" data-icon-close class="hidden h-6 w-6" />
        </button>
    </div>

    <div id="menu-movil" data-menu-panel class="hidden border-t border-line bg-white md:hidden">
        <nav class="container-page flex flex-col gap-1 py-4" aria-label="Móvil">
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}"
                   @if (request()->routeIs($item['route'])) aria-current="page" @endif
                   @class(['nav-link', 'nav-link-active' => request()->routeIs($item['route'])])>{{ $item['label'] }}</a>
            @endforeach

            <a href="{{ $cotizar }}" class="btn btn-primary mt-2 w-full" data-cta="cotizar">
                Cotizar mi sistema
            </a>
        </nav>
    </div>
</header>

<header data-site-header class="sticky top-0 z-[100] border-b border-line bg-white/95 backdrop-blur-sm">
    <div class="container-page flex h-[4.5rem] items-center justify-between gap-4 md:h-[5rem]">
        <a href="{{ route('home') }}" class="shrink-0" aria-label="IntegraTaller — inicio">
            <x-logo class="hidden h-9 md:block" />
            <x-logo tone="mark" class="h-9 md:hidden" />
        </a>

        <nav class="hidden items-center gap-7 md:flex" aria-label="Principal">
            <a href="{{ route('servicios') }}" class="text-sm font-bold text-secondary/80 transition hover:text-primary">Funciones</a>
            <a href="{{ route('home') }}#como-funciona" class="text-sm font-bold text-secondary/80 transition hover:text-primary">Cómo funciona</a>
            <a href="{{ route('tutoriales') }}" class="text-sm font-bold text-secondary/80 transition hover:text-primary">Guías</a>
            <a href="{{ route('contacto') }}" class="text-sm font-bold text-secondary/80 transition hover:text-primary">Contacto</a>
        </nav>

        <div class="hidden md:block">
            <a href="{{ route('contacto') }}" class="btn btn-primary min-h-11 px-5 py-2.5 text-sm" data-cta="demo">
                Solicitar una demo
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
            <a href="{{ route('servicios') }}" class="rounded-sm px-3 py-3 font-bold hover:bg-neutral">Funciones</a>
            <a href="{{ route('home') }}#como-funciona" class="rounded-sm px-3 py-3 font-bold hover:bg-neutral">Cómo funciona</a>
            <a href="{{ route('tutoriales') }}" class="rounded-sm px-3 py-3 font-bold hover:bg-neutral">Guías</a>
            <a href="{{ route('contacto') }}" class="rounded-sm px-3 py-3 font-bold hover:bg-neutral">Contacto</a>
            <a href="{{ route('contacto') }}" class="btn btn-primary mt-2 w-full" data-cta="demo">Solicitar una demo</a>
        </nav>
    </div>
</header>

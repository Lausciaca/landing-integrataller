{{-- "Pedí tu demo" abre este diálogo en la misma pantalla (resources/js/app.js). Sin soporte de <dialog>, el enlace lleva a /contacto. --}}
<dialog data-demo-dialog aria-labelledby="dialogo-demo-titulo" class="dialogo-demo">
    <div class="p-5 pb-[max(1.25rem,env(safe-area-inset-bottom))] sm:p-8" tabindex="-1" autofocus>
        <div class="flex items-start justify-between gap-4">
            <div>
                <span class="oferta">1 mes gratis + 50% en la beta</span>
                <h2 id="dialogo-demo-titulo" class="t-titulo-2 mt-3">Pedí tu demo</h2>
                <p class="mt-1 text-texto-secundario">Tres datos y te escribimos por WhatsApp.</p>
            </div>
            <button type="button" data-dialog-close aria-label="Cerrar"
                    class="-mr-2 -mt-1 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-md text-azul-800 transition-colors hover:bg-gris-100">
                <x-icon name="x" class="h-6 w-6" />
            </button>
        </div>

        <div class="mt-6">
            @include('partials.demo-form', ['prefijo' => 'dialogo-'])
        </div>

        <p class="mt-5 border-t border-borde pt-5 text-center text-texto-secundario">
            ¿Preferís empezar solo?
            <a href="{{ \App\Support\Saas::signupUrl() }}" class="enlace" data-cta="registro" data-registro>Probá 1 mes gratis</a>
        </p>
    </div>
</dialog>

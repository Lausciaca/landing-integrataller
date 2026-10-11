<dialog class="newsletter-dialog"
        data-newsletter-dialog
        data-force-open="{{ $errors->has('subscription_email') && old('subscription_source') === 'popup' ? 'true' : 'false' }}"
        aria-labelledby="newsletter-dialog-title">
    <div class="relative p-6 sm:p-8">
        <button type="button"
                data-newsletter-close
                aria-label="Cerrar"
                class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-sm text-secondary/70 hover:bg-neutral hover:text-secondary">
            <x-icon name="x" class="h-5 w-5" />
        </button>

        <div class="max-w-md pr-8">
            <p class="section-kicker">Ideas para el taller</p>
            <h2 id="newsletter-dialog-title" class="mt-4 font-display text-4xl font-semibold leading-none sm:text-5xl">
                Una mejora útil en cada correo.
            </h2>
            <p class="mt-4 leading-relaxed text-secondary/75">
                Recibí guías prácticas para ordenar turnos, órdenes y stock, además de novedades de IntegraTaller.
            </p>
        </div>

        <div class="mt-6">
            @include('partials.newsletter-form', ['source' => 'popup'])
        </div>
    </div>
</dialog>

{{-- Consentimiento de cookies: Meta, Clarity y GA4 solo cargan si la persona acepta (resources/js/analytics.js). --}}
<div data-cookie-banner hidden role="dialog" aria-modal="false" aria-labelledby="cookies-titulo" aria-describedby="cookies-texto"
     class="fixed inset-x-0 bottom-0 z-[300] p-3 sm:p-6">
    <div class="mx-auto max-w-3xl rounded-lg bg-superficie p-5 shadow-3 sm:p-6">
        <h2 id="cookies-titulo" class="t-titulo-3">Tu privacidad, tu decisión</h2>
        <p id="cookies-texto" class="t-cuerpo-chico mt-2 text-texto-secundario">
            Con tu permiso usamos herramientas de medición
            @if (isset($tags['clarity']) || isset($tags['ga4']))
                ({{ collect([isset($tags['clarity']) ? 'Microsoft Clarity' : null, isset($tags['ga4']) ? 'Google Analytics' : null])->filter()->join(' y ') }})
            @endif
            @if (isset($tags['pixel']))
                y de publicidad (Meta)
            @endif
            para entender cómo se usa el sitio y mejorar nuestros anuncios. La medición propia del sitio es anónima y no usa cookies.
            <a href="{{ route('privacidad') }}#cookies" class="enlace">Más información</a>.
        </p>

        <fieldset data-cookie-options hidden class="mt-4 space-y-3">
            <legend class="sr-only">Elegí qué cookies aceptás</legend>
            <label class="t-cuerpo-chico flex items-start gap-3 rounded-md bg-gris-50 p-3">
                <input type="checkbox" checked disabled class="mt-0.5 h-5 w-5 shrink-0 accent-azul-800">
                <span><span class="font-medium">Necesarias.</span> Hacen funcionar el sitio y los formularios. Siempre activas.</span>
            </label>
            @if (isset($tags['clarity']) || isset($tags['ga4']))
                <label class="t-cuerpo-chico flex cursor-pointer items-start gap-3 rounded-md bg-gris-50 p-3">
                    <input type="checkbox" data-consent="analytics" class="mt-0.5 h-5 w-5 shrink-0 accent-azul-800">
                    <span><span class="font-medium">Medición.</span> Mapas de calor, grabaciones anónimas de navegación y estadísticas de visitas.</span>
                </label>
            @endif
            @if (isset($tags['pixel']))
                <label class="t-cuerpo-chico flex cursor-pointer items-start gap-3 rounded-md bg-gris-50 p-3">
                    <input type="checkbox" data-consent="marketing" class="mt-0.5 h-5 w-5 shrink-0 accent-azul-800">
                    <span><span class="font-medium">Publicidad.</span> Permite a Meta medir nuestros anuncios en Facebook e Instagram.</span>
                </label>
            @endif
        </fieldset>

        <div class="mt-4 flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-end">
            <button type="button" class="boton boton-terciario" data-cookie-configure>Elegir</button>
            <button type="button" class="boton boton-secundario" data-cookie-reject>Rechazar</button>
            <button type="button" class="boton boton-principal" data-cookie-accept>Aceptar</button>
            <button type="button" class="boton boton-principal" data-cookie-save hidden>Guardar elección</button>
        </div>
    </div>
</div>

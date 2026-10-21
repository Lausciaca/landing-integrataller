@php
    $whatsapp = \App\Support\WhatsApp::url();
    $social = array_values(array_filter((array) config('landing.social', [])));
@endphp

<footer class="bg-azul-900 text-azul-100">
    <div class="contenedor grid gap-12 py-16 md:grid-cols-[1.1fr_0.9fr_1.2fr] md:gap-10">
        <div>
            <x-logo variant="negativo" class="h-9" />
            <p class="mt-4 font-medium text-white">Tu taller, en orden.</p>
            <p class="t-cuerpo-chico mt-3 max-w-[34ch]">Órdenes, clientes y finanzas de todas tus sucursales en un solo sistema.</p>
            <ul class="t-cuerpo-chico mt-6 space-y-3">
                <li>
                    <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-white hover:text-celeste-400">
                        <x-icon name="whatsapp" class="h-5 w-5" />
                        Escribinos por WhatsApp
                    </a>
                </li>
                @foreach ($social as $url)
                    <li>
                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-white hover:text-celeste-400">
                            <x-icon name="{{ str_contains($url, 'instagram') ? 'instagram' : 'arrow-right' }}" class="h-5 w-5" />
                            {{ str_contains($url, 'instagram') ? '@integrataller' : parse_url($url, PHP_URL_HOST) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            <h2 class="t-etiqueta !text-celeste-400">Explorá</h2>
            <ul class="t-cuerpo-chico mt-4 space-y-3">
                <li><a href="{{ route('servicios') }}" class="hover:text-white">Funciones</a></li>
                <li><a href="{{ route('features.index') }}" class="hover:text-white">Todas las características</a></li>
                <li><a href="{{ route('cities.index') }}" class="hover:text-white">Talleres por ciudad</a></li>
                <li><a href="{{ route('tutoriales') }}" class="hover:text-white">Guías para el taller</a></li>
                <li><a href="{{ route('contacto') }}" class="hover:text-white">Pedí tu demo</a></li>
            </ul>
        </div>

        <div>
            <h2 class="t-etiqueta !text-celeste-400">Una guía por mes</h2>
            <p class="t-cuerpo-chico mt-4">Ideas prácticas para ordenar el taller y novedades de IntegraTaller. Confirmás tu email antes de recibirlas.</p>
            <div class="mt-4">
                @include('partials.newsletter-form', ['source' => 'footer', 'dark' => true])
            </div>
        </div>
    </div>

    <div class="border-t border-azul-700">
        <div class="contenedor t-cuerpo-chico flex flex-col gap-3 py-6 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} IntegraTaller · Hecho en Argentina</p>
            <ul class="flex gap-6">
                <li><a href="{{ route('terminos') }}" class="hover:text-white">Términos</a></li>
                <li><a href="{{ route('privacidad') }}" class="hover:text-white">Privacidad</a></li>
                @if (array_filter([config('landing.analytics.meta_pixel_id'), config('landing.analytics.clarity_id'), config('landing.analytics.ga4_id')]))
                    <li><button type="button" class="hover:text-white" data-cookie-preferences>Cookies</button></li>
                @endif
            </ul>
        </div>
    </div>
</footer>

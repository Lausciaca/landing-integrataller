@php
    $cotizar = config('landing.app_url');
    $whatsapp = 'https://wa.me/' . config('landing.whatsapp') . '?text=' . rawurlencode(config('landing.whatsapp_message'));
    $year = date('Y');
@endphp

<footer class="bg-secondary text-white">
    <div class="container-page grid gap-10 py-14 sm:grid-cols-2 lg:grid-cols-5 lg:py-16">
        <div class="sm:col-span-2 lg:col-span-2">
            <x-logo tone="light" />
            <p class="mt-4 max-w-sm text-sm leading-relaxed text-white/70">
                Gestión integral para talleres mecánicos en Argentina. Menos papeles, más vehículos entregados.
            </p>
            <p class="mt-3 inline-flex items-center gap-2 text-sm text-white/75">
                <span class="inline-flex items-center rounded-sm bg-accent px-2 py-0.5 text-xs font-bold uppercase tracking-wide text-secondary">Beta</span>
                Acceso Beta en curso.
            </p>
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer"
               class="btn btn-whatsapp mt-6">
                <x-icon name="whatsapp" class="h-5 w-5" />
                Escribinos por WhatsApp
            </a>
        </div>

        <div>
            <h2 class="text-sm font-bold uppercase tracking-wide text-white/90">Secciones</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="{{ route('home') }}" class="text-white/70 transition hover:text-white">Inicio</a></li>
                <li><a href="{{ route('servicios') }}" class="text-white/70 transition hover:text-white">Servicios</a></li>
                <li><a href="{{ route('tutoriales') }}" class="text-white/70 transition hover:text-white">Tutoriales</a></li>
                <li><a href="{{ route('contacto') }}" class="text-white/70 transition hover:text-white">Contacto</a></li>
            </ul>
        </div>

        <div>
            <h2 class="text-sm font-bold uppercase tracking-wide text-white/90">Características</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                @foreach (config('seo.features') as $slug => $feature)
                    <li>
                        <a href="{{ route('features.show', $slug) }}" class="text-white/70 transition hover:text-white">
                            {{ $feature['label'] ?? $feature['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            <h2 class="text-sm font-bold uppercase tracking-wide text-white/90">Legal</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="{{ route('terminos') }}" class="text-white/70 transition hover:text-white">Términos y Condiciones</a></li>
                <li><a href="{{ route('privacidad') }}" class="text-white/70 transition hover:text-white">Política de Privacidad</a></li>
                <li><a href="{{ $cotizar }}" class="text-white/70 transition hover:text-white">Cotizar mi sistema</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-page flex flex-col items-center justify-between gap-3 py-6 text-sm text-white/75 md:flex-row">
            <p>&copy; {{ $year }} IntegraTaller. Todos los derechos reservados.</p>
            <ul class="flex flex-wrap items-center justify-center gap-x-4 gap-y-1">
                @foreach (config('seo.cities') as $slug => $city)
                    <li>
                        <a href="{{ route('cities.show', $slug) }}" class="transition hover:text-white">
                            Talleres en {{ $city['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</footer>

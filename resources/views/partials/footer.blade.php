@php
    $whatsapp = 'https://wa.me/' . config('landing.whatsapp') . '?text=' . rawurlencode(config('landing.whatsapp_message'));
@endphp

<footer class="bg-secondary text-white">
    <div class="container-page grid gap-12 py-14 md:grid-cols-[1fr_1.2fr] md:py-16">
        <div>
            <x-logo tone="light" />
            <p class="mt-5 max-w-md text-sm leading-relaxed text-white/75">
                Un lugar para cada orden, cada vehículo y cada tarea de tu taller.
            </p>
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-white underline decoration-white/40 underline-offset-4 hover:decoration-white">
                <x-icon name="whatsapp" class="h-5 w-5" />
                Consultanos por WhatsApp
            </a>
        </div>

        <div class="grid gap-10 sm:grid-cols-2">
            <div>
                <h2 class="font-display text-2xl font-semibold text-white">Explorá</h2>
                <ul class="mt-4 space-y-3 text-sm text-white/75">
                    <li><a href="{{ route('servicios') }}" class="hover:text-white">Funciones</a></li>
                    <li><a href="{{ route('features.index') }}" class="hover:text-white">Todas las características</a></li>
                    <li><a href="{{ route('cities.index') }}" class="hover:text-white">Talleres por ciudad</a></li>
                    <li><a href="{{ route('tutoriales') }}" class="hover:text-white">Guías para el taller</a></li>
                    <li><a href="{{ route('contacto') }}" class="hover:text-white">Solicitar una demo</a></li>
                </ul>
            </div>

            <div>
                <h2 class="font-display text-2xl font-semibold text-white">Una idea útil por mes</h2>
                <p class="mt-2 text-sm leading-relaxed text-white/75">Guías prácticas y novedades de IntegraTaller. Confirmás tu email antes de recibirlas.</p>
                <div class="mt-4">
                    @include('partials.newsletter-form', ['source' => 'footer', 'dark' => true])
                </div>
                <ul class="mt-6 space-y-3 text-xs text-white/65">
                    <li><a href="{{ route('terminos') }}" class="hover:text-white">Términos</a></li>
                    <li><a href="{{ route('privacidad') }}" class="hover:text-white">Privacidad y datos</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-white/15">
        <div class="container-page flex flex-col gap-2 py-5 text-xs text-white/65 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} IntegraTaller.</p>
            <p>Hecho para el trabajo real del taller.</p>
        </div>
    </div>
</footer>

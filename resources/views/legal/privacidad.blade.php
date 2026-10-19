@extends('layouts.app')

@section('title', 'Política de Privacidad — IntegraTaller')
@section('meta_description', 'Política de Privacidad de IntegraTaller. Cómo tratamos y protegemos los datos de tu taller y de tus clientes.')
@section('canonical', route('privacidad'))

@section('content')
    <x-page-header eyebrow="Legal" title="Política de Privacidad">
        <p class="t-cuerpo-chico mt-4 text-texto-secundario">Última actualización: {{ date('d/m/Y') }}</p>
    </x-page-header>

    <section class="seccion bg-white">
        <div class="contenedor">
            <div class="max-w-[680px] space-y-8 text-texto">
                <div>
                    <h2 class="t-titulo-3">1. Introducción</h2>
                    <p class="mt-2">
                        En IntegraTaller cuidamos la información de tu taller y de tus clientes. Esta Política de
                        Privacidad describe qué datos recolectamos, para qué los usamos y cómo los protegemos. Es un
                        texto base editable que debe ser revisado por un profesional legal antes de su publicación.
                    </p>
                </div>

                <div>
                    <h2 class="t-titulo-3">2. Datos que recolectamos</h2>
                    <p class="mt-2">
                        Datos de contacto que nos dejás por formulario o WhatsApp (nombre, taller, email, celular y
                        consulta), junto con los datos que cargás dentro de la plataforma. Si solicitás recibir emails
                        con guías y novedades, registramos tu dirección, el origen de la suscripción y cuándo la
                        confirmaste.
                    </p>
                </div>

                <div>
                    <h2 class="t-titulo-3">3. Finalidad</h2>
                    <p class="mt-2">
                        Utilizamos los datos de contacto para responder solicitudes de demo y consultas. Solo enviamos
                        guías y novedades mensuales a quienes confirman esa suscripción; podés darte de baja desde el
                        enlace que incluimos en los emails. No vendemos tus datos personales.
                    </p>
                </div>

                <div>
                    <h2 class="t-titulo-3">4. Almacenamiento y seguridad</h2>
                    <p class="mt-2">
                        La información se aloja en servidores seguros con copias de seguridad automáticas y controles
                        de acceso. Aplicamos medidas técnicas y organizativas para evitar accesos no autorizados.
                    </p>
                </div>

                <div>
                    <h2 class="t-titulo-3">5. Tus derechos</h2>
                    <p class="mt-2">
                        Podés solicitar el acceso, la corrección o la eliminación de tus datos escribiéndonos a
                        través de <a href="{{ route('contacto') }}" class="enlace">nuestra página de contacto</a>.
                    </p>
                </div>

                <div id="cookies">
                    <h2 class="t-titulo-3">6. Cookies y medición</h2>
                    <p class="mt-2">
                        Usamos cookies necesarias para el funcionamiento del sitio y de los formularios. Además medimos
                        las visitas con una herramienta propia, anónima y sin cookies: registramos qué páginas se ven,
                        desde qué fuente o campaña se llegó y qué botones se usan, sin guardar tu dirección IP ni datos
                        que te identifiquen.
                    </p>
                    <p class="mt-2">
                        Solo si lo aceptás en el aviso de cookies, también usamos:
                    </p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        <li><span class="font-medium">Microsoft Clarity</span>: mapas de calor y grabaciones anónimas de la navegación para mejorar el sitio.</li>
                        <li><span class="font-medium">Google Analytics</span>: estadísticas de visitas.</li>
                        <li><span class="font-medium">Meta (Facebook e Instagram)</span>: medir el resultado de nuestros anuncios. Si pedís una demo o te suscribís, le enviamos a Meta tu email y teléfono cifrados (hash) para atribuir la conversión.</li>
                    </ul>
                    <p class="mt-2">
                        Podés cambiar tu elección cuando quieras desde el enlace «Cookies» al pie de cada página.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('head')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => 'Política de Privacidad — IntegraTaller',
            'url' => route('privacidad'),
            'inLanguage' => 'es-AR',
            'dateModified' => now()->toAtomString(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

@extends('layouts.app')

@section('title', 'Política de Privacidad — IntegraTaller')
@section('meta_description', 'Política de Privacidad de IntegraTaller. Cómo tratamos y protegemos los datos de tu taller y de tus clientes.')
@section('canonical', route('privacidad'))

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <div class="mx-auto max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.14em] text-primary">Legal</p>
                <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">Política de Privacidad</h1>
                <p class="mt-4 text-secondary/70">Última actualización: {{ date('d/m/Y') }}</p>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="container-page section-gap">
            <div class="mx-auto max-w-3xl space-y-8 leading-relaxed text-secondary/80">
                <div>
                    <h2 class="text-xl font-bold text-secondary">1. Introducción</h2>
                    <p class="mt-2">
                        En IntegraTaller cuidamos la información de tu taller y de tus clientes. Esta Política de
                        Privacidad describe qué datos recolectamos, para qué los usamos y cómo los protegemos. Es un
                        texto base editable que debe ser revisado por un profesional legal antes de su publicación.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-secondary">2. Datos que recolectamos</h2>
                    <p class="mt-2">
                        Datos de contacto que nos dejás por formulario o WhatsApp (nombre, taller, celular, consulta)
                        y los datos que cargás dentro de la plataforma (clientes, vehículos, órdenes, repuestos y
                        movimientos de caja).
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-secondary">3. Finalidad</h2>
                    <p class="mt-2">
                        Utilizamos los datos para prestar el servicio, brindar soporte, gestionar la facturación y
                        mejorar la plataforma. No vendemos ni cedemos datos personales a terceros con fines
                        publicitarios.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-secondary">4. Almacenamiento y seguridad</h2>
                    <p class="mt-2">
                        La información se aloja en servidores seguros con copias de seguridad automáticas y controles
                        de acceso. Aplicamos medidas técnicas y organizativas para evitar accesos no autorizados.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-secondary">5. Tus derechos</h2>
                    <p class="mt-2">
                        Podés solicitar el acceso, la corrección o la eliminación de tus datos escribiéndonos a
                        través de <a href="{{ route('contacto') }}" class="font-semibold text-primary underline">nuestra página de contacto</a>.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-secondary">6. Cookies</h2>
                    <p class="mt-2">
                        Usamos cookies necesarias para el funcionamiento del sitio y de la plataforma. Podés
                        configurar tu navegador para bloquearlas, aunque algunas funciones podrían verse afectadas.
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

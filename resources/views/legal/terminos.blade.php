@extends('layouts.app')

@section('title', 'Términos y Condiciones — IntegraTaller')
@section('meta_description', 'Términos y Condiciones de uso de IntegraTaller, software de gestión para talleres mecánicos.')
@section('canonical', route('terminos'))

@section('content')
    <x-page-header eyebrow="Legal" title="Términos y Condiciones">
        <p class="t-cuerpo-chico mt-4 text-texto-secundario">Última actualización: {{ date('d/m/Y') }}</p>
    </x-page-header>

    <section class="seccion bg-white">
        <div class="contenedor">
            <div class="max-w-[680px] space-y-8 text-texto">
                <div>
                    <h2 class="t-titulo-3">1. Aceptación</h2>
                    <p class="mt-2">
                        Al contratar y utilizar IntegraTaller aceptás estos Términos y Condiciones. Si no estás de
                        acuerdo, no utilices el servicio. Este documento es un texto base editable y debe ser
                        revisado por un profesional legal antes de su publicación definitiva.
                    </p>
                </div>

                <div>
                    <h2 class="t-titulo-3">2. Descripción del servicio</h2>
                    <p class="mt-2">
                        IntegraTaller es una plataforma de gestión en la nube para talleres mecánicos. Provee módulos
                        de órdenes de trabajo, control de stock, caja y finanzas, clientes, vehículos y avisos
                        automáticos.
                    </p>
                </div>

                <div>
                    <h2 class="t-titulo-3">3. Cuenta y accesos</h2>
                    <p class="mt-2">
                        El taller es responsable de la veracidad de los datos ingresados y de la confidencialidad de
                        sus credenciales. La activación del entorno de trabajo se realiza de forma automática una vez
                        confirmado el pago.
                    </p>
                </div>

                <div>
                    <h2 class="t-titulo-3">4. Pagos y facturación</h2>
                    <p class="mt-2">
                        Los precios se expresan en pesos argentinos (AR$) y pueden variar según el tamaño y las
                        necesidades del taller. El pago se procesa a través de los medios de pago que se acuerden al contratar.
                    </p>
                </div>

                <div>
                    <h2 class="t-titulo-3">5. Uso aceptable</h2>
                    <p class="mt-2">
                        No está permitido utilizar la plataforma para actividades ilícitas, intentar vulnerar su
                        seguridad ni revender el servicio sin autorización expresa.
                    </p>
                </div>

                <div>
                    <h2 class="t-titulo-3">6. Disponibilidad y soporte</h2>
                    <p class="mt-2">
                        Realizamos nuestros mejores esfuerzos para mantener el servicio disponible de forma continua,
                        con monitoreo y copias de seguridad automáticas. El soporte se brinda por WhatsApp y por
                        sistema de tickets.
                    </p>
                </div>

                <div>
                    <h2 class="t-titulo-3">7. Limitación de responsabilidad</h2>
                    <p class="mt-2">
                        IntegraTaller no será responsable por daños indirectos derivados del uso del servicio. La
                        información del taller es propiedad de cada cliente.
                    </p>
                </div>

                <div>
                    <h2 class="t-titulo-3">8. Contacto</h2>
                    <p class="mt-2">
                        Para consultas sobre estos términos, escribinos por
                        <a href="{{ route('contacto') }}" class="enlace">nuestra página de contacto</a>.
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
            'name' => 'Términos y Condiciones — IntegraTaller',
            'url' => route('terminos'),
            'inLanguage' => 'es-AR',
            'dateModified' => now()->toAtomString(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush

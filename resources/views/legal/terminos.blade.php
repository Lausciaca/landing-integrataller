@extends('layouts.app')

@section('title', 'Términos y Condiciones — IntegraTaller')
@section('meta_description', 'Términos y Condiciones de uso de IntegraTaller, software de gestión para talleres mecánicos.')
@section('canonical', route('terminos'))

@section('content')
    <section class="border-b border-line bg-neutral">
        <div class="container-page section-gap">
            <div class="mx-auto max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.14em] text-primary">Legal</p>
                <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">Términos y Condiciones</h1>
                <p class="mt-4 text-secondary/70">Última actualización: {{ date('d/m/Y') }}</p>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="container-page section-gap">
            <div class="mx-auto max-w-3xl space-y-8 leading-relaxed text-secondary/80">
                <div>
                    <h2 class="text-xl font-bold text-secondary">1. Aceptación</h2>
                    <p class="mt-2">
                        Al contratar y utilizar IntegraTaller aceptás estos Términos y Condiciones. Si no estás de
                        acuerdo, no utilices el servicio. Este documento es un texto base editable y debe ser
                        revisado por un profesional legal antes de su publicación definitiva.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-secondary">2. Descripción del servicio</h2>
                    <p class="mt-2">
                        IntegraTaller es una plataforma de gestión en la nube para talleres mecánicos. Provee módulos
                        de órdenes de trabajo, control de stock, caja y finanzas, clientes, vehículos y avisos
                        automáticos.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-secondary">3. Cuenta y accesos</h2>
                    <p class="mt-2">
                        El taller es responsable de la veracidad de los datos ingresados y de la confidencialidad de
                        sus credenciales. La activación del entorno de trabajo se realiza de forma automática una vez
                        confirmado el pago.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-secondary">4. Pagos y facturación</h2>
                    <p class="mt-2">
                        Los precios se expresan en pesos argentinos (AR$) y pueden variar según el tamaño y las
                        necesidades del taller. El pago se procesa a través de los medios habilitados en el cotizador.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-secondary">5. Uso aceptable</h2>
                    <p class="mt-2">
                        No está permitido utilizar la plataforma para actividades ilícitas, intentar vulnerar su
                        seguridad ni revender el servicio sin autorización expresa.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-secondary">6. Disponibilidad y soporte</h2>
                    <p class="mt-2">
                        Realizamos nuestros mejores esfuerzos para mantener el servicio disponible de forma continua,
                        con monitoreo y copias de seguridad automáticas. El soporte se brinda por WhatsApp y por
                        sistema de tickets.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-secondary">7. Limitación de responsabilidad</h2>
                    <p class="mt-2">
                        IntegraTaller no será responsable por daños indirectos derivados del uso del servicio. La
                        información del taller es propiedad de cada cliente.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-secondary">8. Contacto</h2>
                    <p class="mt-2">
                        Para consultas sobre estos términos, escribinos por
                        <a href="{{ route('contacto') }}" class="font-semibold text-primary underline">nuestra página de contacto</a>.
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

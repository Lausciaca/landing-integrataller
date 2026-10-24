{{--
    Precios de la home. Los datos salen de los planes del SaaS (App\Services\PlanesPublicos):
    lo que el dueño edita en el panel de superadmin se refleja solo. Precio fijo por plan:
    sucursales y usuarios no suman.
--}}
@php
    use App\Services\PlanesPublicos;

    $pro = $precios['pro'];
    $corporation = $precios['corporation'];
    $porcentaje = fn (float $valor) => rtrim(rtrim(number_format($valor, 2, ',', ''), '0'), ',');
    $pruebaTexto = match (true) {
        $precios['prueba_dias'] === 30 => '1 mes gratis',
        $precios['prueba_dias'] > 0 => $precios['prueba_dias'].' días gratis',
        default => null,
    };
    $oferta = collect([$pruebaTexto, $pro['descuento_pct'] > 0 ? $porcentaje($pro['descuento_pct']).'% en la beta' : null])->filter()->join(' + ');
    $ahorro = $pro['precio'] - $pro['precio_final'];
    $funciones = ['Órdenes de trabajo', 'Clientes y vehículos', 'Caja y finanzas', 'Stock de repuestos', 'Turnos', 'Reportes', 'Presupuestos por WhatsApp', 'Seguimiento para el cliente'];
    // IA verificada en el SaaS: lectura de tickets de gastos, asistente de campañas y asistente de ayuda.
    $conIa = $corporation ? array_values(array_filter([
        'Todo lo del plan '.$pro['nombre'],
        $corporation['ia_consultas'] > 0 ? number_format($corporation['ia_consultas'], 0, ',', '.').' consultas de IA por mes' : null,
        'Lectura de tickets de gastos con IA',
        'Asistente con IA para tus campañas',
        'Ayuda con IA dentro del sistema',
    ])) : [];
    $confianza = [
        ['icon' => 'credit-card', 'texto' => 'Empezás sin tarjeta'],
        ['icon' => 'cloud', 'texto' => 'Sin instalación'],
        ['icon' => 'banknote', 'texto' => 'Precio fijo en pesos'],
        ['icon' => 'whatsapp', 'texto' => 'Soporte por WhatsApp'],
    ];
@endphp

<section id="precios" class="seccion bg-white" aria-labelledby="precios-title">
    <div class="contenedor">
        <x-section-heading data-revelar id="precios-title" align="center" eyebrow="Precios" title="Un precio fijo, en pesos." subtitle="Pagás el plan y listo: todas tus sucursales y todo tu equipo, sin costo extra." />

        <div @class([
            'mx-auto mt-10 grid max-w-[1040px] gap-5 md:mt-14 lg:items-stretch lg:gap-6',
            'lg:grid-cols-[1.2fr_1fr]' => $corporation,
            'max-w-[640px]' => ! $corporation,
        ])>
            {{-- Plan Pro: el principal, destacado con el azul de la marca --}}
            <article data-revelar class="precio-destacado relative flex flex-col overflow-hidden rounded-xl p-6 text-white sm:p-8 md:p-10">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h3 class="t-titulo-2 !text-white">Plan {{ $pro['nombre'] }}</h3>
                    @if ($oferta !== '')
                        <span class="oferta">{{ $oferta }}</span>
                    @endif
                </div>
                <p class="mt-2 text-azul-100">Para talleres con una o varias sucursales.</p>

                <div class="mt-8">
                    @if ($ahorro > 0)
                        <p class="flex flex-wrap items-center gap-x-3 gap-y-1">
                            <s class="text-azul-100 tabular-nums"><span class="sr-only">Precio de lista: </span>{{ PlanesPublicos::pesos($pro['precio']) }}</s>
                            <span class="t-cuerpo-chico rounded-full bg-celeste-500/20 px-2.5 py-0.5 font-medium text-celeste-400">Ahorrás {{ PlanesPublicos::pesos($ahorro) }} por mes</span>
                        </p>
                    @endif
                    <p class="mt-1 flex flex-wrap items-baseline gap-x-3">
                        <span class="text-[48px] font-bold leading-[52px] tracking-[-0.02em] tabular-nums md:text-[60px] md:leading-[64px]">{{ PlanesPublicos::pesos($pro['precio_final']) }}</span>
                        <span class="text-azul-100">por mes, final</span>
                    </p>
                    {{-- TODO-CONFIRMAR: línea de confianza (config/landing.php, copy.pricing_trust_line) --}}
                    <p class="t-cuerpo-chico mt-2 text-azul-100">{{ config('landing.copy.pricing_trust_line') }}</p>
                    @if ($precios['transferencia_descuento_pct'] > 0)
                        <p class="t-cuerpo-chico mt-1 font-medium text-celeste-400">{{ $porcentaje($precios['transferencia_descuento_pct']) }}% menos pagando por transferencia</p>
                    @endif
                </div>

                <div class="mt-8 border-t border-azul-700 pt-6">
                    <p class="flex items-start gap-2 font-medium">
                        <x-icon name="store" class="mt-0.5 h-5 w-5 shrink-0 text-celeste-400" />
                        Todas tus sucursales y todo tu equipo, sin costo extra.
                    </p>
                    <ul class="mt-4 grid gap-x-6 gap-y-2.5 sm:grid-cols-2">
                        @foreach ($funciones as $funcion)
                            <li class="flex items-start gap-2 text-azul-50">
                                <x-icon name="check" class="mt-0.5 h-5 w-5 shrink-0 text-celeste-400" />
                                <span>{{ $funcion }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-auto pt-8">
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ \App\Support\Saas::signupUrl() }}" class="boton boton-claro" data-cta="registro" data-registro>{{ $pruebaTexto ? 'Probá '.$pruebaTexto : 'Empezá ahora' }}</a>
                        <a href="{{ route('contacto') }}" class="boton boton-borde-claro" data-cta="demo">Pedí tu demo</a>
                    </div>
                    @if ($pruebaTexto)
                        <p class="t-cuerpo-chico mt-4 text-azul-100">Empezás hoy, sin tarjeta. Si te sirve, activás el débito automático con MercadoPago antes de que termine la prueba.</p>
                    @endif
                </div>
            </article>

            @if ($corporation)
                <article data-revelar class="flex flex-col rounded-xl border border-borde bg-white p-6 sm:p-8 md:p-10">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <h3 class="t-titulo-2">Plan {{ $corporation['nombre'] }}</h3>
                        <x-estado tipo="info">Con IA</x-estado>
                    </div>
                    <p class="mt-2 text-texto-secundario">Para redes de sucursales que quieren sumar inteligencia artificial.</p>

                    <div class="mt-8">
                        @if ($corporation['descuento_pct'] > 0)
                            <p class="text-texto-secundario">
                                <s class="tabular-nums"><span class="sr-only">Precio de lista: </span>{{ PlanesPublicos::pesos($corporation['precio']) }}</s>
                            </p>
                        @endif
                        <p class="mt-1 flex flex-wrap items-baseline gap-x-3">
                            <span class="text-[40px] font-bold leading-[44px] tracking-[-0.02em] text-azul-800 tabular-nums md:text-[48px] md:leading-[52px]">{{ PlanesPublicos::pesos($corporation['precio_final']) }}</span>
                            <span class="text-texto-secundario">por mes, final</span>
                        </p>
                    </div>

                    <ul class="mt-8 grid gap-2.5 border-t border-borde pt-6">
                        @foreach ($conIa as $item)
                            <li class="flex items-start gap-2">
                                <x-icon name="check" class="mt-0.5 h-5 w-5 shrink-0 text-celeste-700" />
                                <span @class(['font-medium text-azul-800' => $loop->first])>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-auto pt-8">
                        <a href="{{ route('contacto') }}" class="boton boton-secundario w-full sm:w-auto" data-cta="demo">Pedí tu demo</a>
                        <p class="t-cuerpo-chico mt-4 text-texto-secundario">Te mostramos cómo funciona la IA con los datos de tu taller.</p>
                    </div>
                </article>
            @endif
        </div>

        <ul data-revelar class="mx-auto mt-8 grid max-w-[1040px] grid-cols-2 gap-x-6 gap-y-3 md:mt-10 md:flex md:flex-wrap md:justify-center md:gap-x-10">
            @foreach ($confianza as $item)
                <li class="t-cuerpo-chico flex items-center gap-2 font-medium text-azul-800">
                    <x-icon :name="$item['icon']" class="h-5 w-5 shrink-0 text-celeste-700" />
                    {{ $item['texto'] }}
                </li>
            @endforeach
        </ul>
    </div>
</section>

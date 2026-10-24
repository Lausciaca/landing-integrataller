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
    $funciones = ['Órdenes de trabajo', 'Clientes y vehículos', 'Caja y finanzas', 'Stock', 'Turnos', 'Reportes', 'Presupuestos que mandás por WhatsApp'];
@endphp

<section id="precios" class="seccion bg-white" aria-labelledby="precios-title">
    <div class="contenedor">
        <x-section-heading data-revelar id="precios-title" eyebrow="Precios" title="Un precio fijo, en pesos." subtitle="Pagás el plan y listo: todas tus sucursales y todo tu equipo, sin costo extra. Sin costos de instalación." />

        <div @class([
            'mt-10 grid gap-5 md:mt-12 lg:gap-6',
            'lg:grid-cols-[1.25fr_1fr]' => $corporation,
            'max-w-[720px]' => ! $corporation,
        ])>
            {{-- Plan Pro --}}
            <article data-revelar class="funcion flex flex-col !border-azul-800 p-6 sm:p-8 md:p-10">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h3 class="t-titulo-2">Plan {{ $pro['nombre'] }}</h3>
                    @if ($oferta !== '')
                        <span class="oferta">{{ $oferta }}</span>
                    @endif
                </div>

                <div class="mt-6">
                    @if ($pro['descuento_pct'] > 0)
                        <p class="text-texto-secundario">
                            <span class="sr-only">Precio de lista:</span>
                            <s class="tabular-nums">{{ PlanesPublicos::pesos($pro['precio']) }}</s>
                        </p>
                    @endif
                    <p class="mt-1 flex flex-wrap items-baseline gap-x-3">
                        <span class="text-[44px] font-bold leading-[48px] tracking-[-0.02em] text-azul-800 tabular-nums md:text-[56px] md:leading-[60px]">{{ PlanesPublicos::pesos($pro['precio_final']) }}</span>
                        <span class="text-texto-secundario">por mes, final</span>
                    </p>
                    {{-- TODO-CONFIRMAR: línea de confianza (config/landing.php, copy.pricing_trust_line) --}}
                    <p class="t-cuerpo-chico mt-2 text-texto-secundario">{{ config('landing.copy.pricing_trust_line') }}</p>
                    @if ($precios['transferencia_descuento_pct'] > 0)
                        <p class="t-cuerpo-chico mt-2 font-medium text-exito">{{ $porcentaje($precios['transferencia_descuento_pct']) }}% menos pagando por transferencia</p>
                    @endif
                </div>

                <div class="mt-6 border-t border-borde pt-6">
                    <p class="flex items-start gap-2 font-medium text-azul-800">
                        <x-icon name="store" class="mt-0.5 h-5 w-5 shrink-0 text-celeste-700" />
                        Todas tus sucursales y todo tu equipo, sin costo extra.
                    </p>
                    <ul class="mt-4 grid gap-2 sm:grid-cols-2">
                        @foreach ($funciones as $funcion)
                            <li class="flex items-start gap-2">
                                <x-icon name="check" class="mt-0.5 h-5 w-5 shrink-0 text-celeste-700" />
                                <span>{{ $funcion }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-auto pt-8">
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ \App\Support\Saas::signupUrl() }}" class="boton boton-principal" data-cta="registro" data-registro>{{ $pruebaTexto ? 'Probá '.$pruebaTexto : 'Empezá ahora' }}</a>
                        <a href="{{ route('contacto') }}" class="boton boton-secundario" data-cta="demo">Pedí tu demo</a>
                    </div>
                </div>
            </article>

            @if ($corporation)
                <article data-revelar class="flex flex-col rounded-xl bg-azul-50 p-6 sm:p-8 md:p-10">
                    <h3 class="t-titulo-2">Plan {{ $corporation['nombre'] }}</h3>
                    <p class="mt-2 text-texto-secundario">Para redes de sucursales, con IA.</p>

                    <div class="mt-6">
                        @if ($corporation['descuento_pct'] > 0)
                            <p class="text-texto-secundario">
                                <span class="sr-only">Precio de lista:</span>
                                <s class="tabular-nums">{{ PlanesPublicos::pesos($corporation['precio']) }}</s>
                            </p>
                        @endif
                        <p class="mt-1 flex flex-wrap items-baseline gap-x-3">
                            <span class="t-dato-grande tabular-nums text-azul-800">{{ PlanesPublicos::pesos($corporation['precio_final']) }}</span>
                            <span class="text-texto-secundario">por mes, final</span>
                        </p>
                    </div>

                    {{-- IA verificada en el SaaS: lectura de tickets de gastos y asistente de campañas --}}
                    <ul class="mt-6 grid gap-2 border-t border-azul-100 pt-6">
                        @foreach (['Todo lo del plan '.$pro['nombre'], 'Lectura de tickets de gastos con IA', 'Asistente con IA para tus campañas'] as $item)
                            <li class="flex items-start gap-2">
                                <x-icon name="check" class="mt-0.5 h-5 w-5 shrink-0 text-celeste-700" />
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-auto pt-8">
                        <a href="{{ route('contacto') }}" class="boton boton-secundario w-full sm:w-auto" data-cta="demo">Pedí tu demo</a>
                    </div>
                </article>
            @endif
        </div>
    </div>
</section>

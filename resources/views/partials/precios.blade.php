{{--
    Precios de la home. Los datos salen de los planes del SaaS (App\Services\PlanesPublicos):
    lo que el dueño edita en el panel de superadmin se refleja solo. La calculadora
    (resources/js/precios.js) replica Suscripciones::calcularMontoEstimado del SaaS.
--}}
@php
    use App\Services\PlanesPublicos;

    $pro = $precios['pro'];
    $corporation = $precios['corporation'];
    $porcentaje = fn (float $valor) => rtrim(rtrim(number_format($valor, 2, ',', ''), '0'), ',');
    $plural = fn (int $n, string $uno, string $varios) => $n.' '.($n === 1 ? $uno : $varios);
    $pruebaTexto = match (true) {
        $precios['prueba_dias'] === 30 => '1 mes gratis',
        $precios['prueba_dias'] > 0 => $precios['prueba_dias'].' días gratis',
        default => null,
    };
    $oferta = collect([$pruebaTexto, $pro['descuento_pct'] > 0 ? $porcentaje($pro['descuento_pct']).'% en la beta' : null])->filter()->join(' + ');
    $inicial = PlanesPublicos::estimar($pro);
    $funciones = ['Órdenes de trabajo', 'Clientes y vehículos', 'Caja y finanzas', 'Stock', 'Turnos', 'Reportes', 'Presupuestos que mandás por WhatsApp'];
@endphp

<section id="precios" class="seccion bg-white" aria-labelledby="precios-title">
    <div class="contenedor">
        <x-section-heading data-revelar id="precios-title" eyebrow="Precios" title="Un precio claro, en pesos." subtitle="Pagás por mes según tus sucursales y las personas que usan el sistema. Sin costos de instalación." />

        <div class="mt-10 grid gap-5 md:mt-12 lg:grid-cols-[1fr_1fr] lg:gap-6">
            {{-- Plan Pro --}}
            <article data-revelar class="funcion flex flex-col p-6 sm:p-8">
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
                    @if ($precios['transferencia_descuento_pct'] > 0)
                        <p class="t-cuerpo-chico mt-2 font-medium text-exito">{{ $porcentaje($precios['transferencia_descuento_pct']) }}% menos pagando por transferencia</p>
                    @endif
                </div>

                <div class="mt-6 border-t border-borde pt-6">
                    <p class="font-medium text-azul-800">
                        Incluye {{ $plural($pro['talleres_incluidos'], 'sucursal', 'sucursales') }} y {{ $plural($pro['usuarios_incluidos'], 'usuario', 'usuarios') }}.
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

                <p class="t-cuerpo-chico mt-6 text-texto-secundario">
                    {{ $plural($pro['talleres_incluidos'], 'sucursal incluida', 'sucursales incluidas') }}; cada sucursal extra suma {{ PlanesPublicos::pesos($pro['precio_taller_extra']) }} y cada usuario extra, {{ PlanesPublicos::pesos($pro['precio_usuario_extra']) }} por mes.
                </p>
            </article>

            {{-- Calculadora --}}
            <div data-revelar class="flex flex-col rounded-xl bg-azul-50 p-6 sm:p-8" data-calculadora>
                <h3 class="t-titulo-3">Calculá el total de tu taller</h3>

                <div class="mt-6 grid gap-5 sm:grid-cols-2 sm:items-end">
                    <div>
                        <label for="calc-sucursales" class="rotulo">¿Cuántas sucursales?</label>
                        <select id="calc-sucursales" class="campo" data-calc="talleres">
                            @foreach (range(1, 10) as $n)
                                <option value="{{ $n }}" @selected($n === 1)>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="calc-personas" class="rotulo">¿Cuántas personas usan el sistema?</label>
                        <select id="calc-personas" class="campo" data-calc="usuarios" aria-describedby="calc-personas-ayuda">
                            @foreach (range(1, 30) as $n)
                                <option value="{{ $n }}" @selected($n === $pro['usuarios_incluidos'])>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <p id="calc-personas-ayuda" class="t-cuerpo-chico mt-2 text-texto-secundario">Personas: contando al dueño y a los empleados.</p>

                <dl class="mt-6 space-y-3 border-t border-azul-100 pt-6" aria-live="polite">
                    <div class="flex items-baseline justify-between gap-4">
                        <dt class="text-texto-secundario">Plan {{ $pro['nombre'] }}</dt>
                        <dd class="tabular-nums" data-calc-salida="base">{{ PlanesPublicos::pesos($inicial['base']) }}</dd>
                    </div>
                    <div class="flex items-baseline justify-between gap-4">
                        <dt class="text-texto-secundario">Sucursales extra <span data-calc-salida="talleres_extra">({{ $inicial['talleres_extra'] }})</span></dt>
                        <dd class="tabular-nums" data-calc-salida="monto_talleres">{{ PlanesPublicos::pesos($inicial['monto_talleres']) }}</dd>
                    </div>
                    <div class="flex items-baseline justify-between gap-4">
                        <dt class="text-texto-secundario">Usuarios extra <span data-calc-salida="usuarios_extra">({{ $inicial['usuarios_extra'] }})</span></dt>
                        <dd class="tabular-nums" data-calc-salida="monto_usuarios">{{ PlanesPublicos::pesos($inicial['monto_usuarios']) }}</dd>
                    </div>
                    <div class="flex items-baseline justify-between gap-4 border-t border-azul-100 pt-3">
                        <dt class="font-medium text-azul-800">Total por mes, estimado</dt>
                        <dd class="t-dato-grande tabular-nums text-azul-800" data-calc-salida="total">{{ PlanesPublicos::pesos($inicial['total']) }}</dd>
                    </div>
                </dl>
                <p class="t-cuerpo-chico mt-3 text-texto-secundario">El descuento de la beta va sobre el plan; las sucursales y los usuarios extra, a precio lleno.</p>

                <div class="mt-auto pt-8">
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ \App\Support\Saas::signupUrl() }}" class="boton boton-principal" data-cta="registro" data-registro>{{ $pruebaTexto ? 'Probá '.$pruebaTexto : 'Empezá ahora' }}</a>
                        <a href="{{ route('contacto') }}" class="boton boton-secundario" data-cta="demo">Pedí tu demo</a>
                    </div>
                    <p class="t-cuerpo-chico mt-4 text-texto-secundario">{{ config('landing.copy.pricing_trust_line') }}</p>
                </div>
            </div>
        </div>

        @if ($corporation)
            <article data-revelar class="mt-5 flex flex-col gap-6 rounded-xl border border-borde p-6 sm:p-8 md:flex-row md:items-center md:justify-between lg:mt-6">
                <div>
                    <h3 class="t-titulo-3">Plan {{ $corporation['nombre'] }}</h3>
                    <p class="mt-1 text-texto-secundario">Para redes de sucursales, con IA.</p>
                </div>
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:gap-8">
                    <p>
                        @if ($corporation['descuento_pct'] > 0)
                            <s class="t-cuerpo-chico block text-texto-secundario tabular-nums"><span class="sr-only">Precio de lista: </span>{{ PlanesPublicos::pesos($corporation['precio']) }}</s>
                        @endif
                        <span class="t-dato tabular-nums text-azul-800">{{ PlanesPublicos::pesos($corporation['precio_final']) }}</span>
                        <span class="t-cuerpo-chico text-texto-secundario">por mes, final</span>
                    </p>
                    <a href="{{ route('contacto') }}" class="boton boton-secundario shrink-0" data-cta="demo">Pedí tu demo</a>
                </div>
            </article>
        @endif
    </div>

    <script type="application/json" id="precios-datos">@json($pro)</script>
</section>

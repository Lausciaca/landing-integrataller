{{--
    Formulario corto de demo: nombre, WhatsApp y sucursales. Lo usan el diálogo
    (partials/demo-dialog) y la página /contacto; $prefijo evita ids repetidos.
    resources/js/app.js lo envía con fetch y muestra los errores sin recargar.
--}}
@php
    $prefijo ??= '';
    $campos = [
        ['id' => 'name', 'label' => 'Tu nombre', 'type' => 'text', 'autocomplete' => 'name', 'max' => 120, 'placeholder' => 'Nombre y apellido'],
        ['id' => 'phone', 'label' => 'Tu WhatsApp', 'type' => 'tel', 'autocomplete' => 'tel', 'max' => 40, 'placeholder' => 'Ej: 336 412-3456'],
    ];
@endphp

<form method="POST" action="{{ route('contacto.store') }}" class="space-y-5" data-demo-form novalidate>
    <input type="hidden" name="attribution" data-attribution>
    <div class="absolute -left-[9999px]" aria-hidden="true">
        <label for="{{ $prefijo }}website">No completes este campo</label>
        <input id="{{ $prefijo }}website" name="website" type="text" tabindex="-1" autocomplete="off">
    </div>

    @foreach ($campos as $campo)
        <div>
            <label for="{{ $prefijo }}{{ $campo['id'] }}" class="rotulo">{{ $campo['label'] }}</label>
            <input id="{{ $prefijo }}{{ $campo['id'] }}"
                   name="{{ $campo['id'] }}"
                   type="{{ $campo['type'] }}"
                   value="{{ old($campo['id']) }}"
                   autocomplete="{{ $campo['autocomplete'] }}"
                   maxlength="{{ $campo['max'] }}"
                   placeholder="{{ $campo['placeholder'] }}"
                   @if ($campo['type'] === 'tel') inputmode="tel" @endif
                   aria-describedby="{{ $prefijo }}{{ $campo['id'] }}-error"
                   @error($campo['id']) aria-invalid="true" @enderror
                   required
                   class="campo">
            <p id="{{ $prefijo }}{{ $campo['id'] }}-error" class="error-campo" data-error-for="{{ $campo['id'] }}" @error($campo['id']) @else hidden @enderror>@error($campo['id']){{ $message }}@enderror</p>
        </div>
    @endforeach

    <fieldset aria-describedby="{{ $prefijo }}branches-error" @error('branches') aria-invalid="true" @enderror data-campo="branches">
        <legend class="rotulo">¿Cuántas sucursales tiene tu taller?</legend>
        <div class="grid grid-cols-4 gap-2">
            @foreach (\App\Models\Contact::BRANCHES as $valor => $texto)
                <label class="opcion">
                    <input type="radio" name="branches" value="{{ $valor }}" @checked(old('branches') === (string) $valor) required class="peer sr-only">
                    <span>{{ $texto }}</span>
                </label>
            @endforeach
        </div>
        <p id="{{ $prefijo }}branches-error" class="error-campo" data-error-for="branches" @error('branches') @else hidden @enderror>@error('branches'){{ $message }}@enderror</p>
    </fieldset>

    <div class="aviso aviso-error" role="alert" data-form-aviso hidden>
        <x-icon name="alert-circle" class="h-5 w-5 shrink-0" />
        <p>
            <span class="font-medium">No pudimos enviar tu pedido.</span>
            Probá de nuevo o <a href="{{ \App\Support\WhatsApp::url() }}" target="_blank" rel="noopener noreferrer" class="enlace">escribinos por WhatsApp</a>.
        </p>
    </div>

    <button type="submit" class="boton boton-principal w-full" data-cta="demo-enviar" data-submit>Quiero mi demo por WhatsApp</button>

    <p class="t-cuerpo-chico text-texto-secundario">
        Te escribimos por WhatsApp para coordinarla. Usamos tus datos solo para eso: <a href="{{ route('privacidad') }}" class="enlace">política de privacidad</a>.
    </p>
</form>

@php
    $dark = $dark ?? false;
    $source = $source ?? 'inline';
    $formId = 'newsletter-' . $source;
    $isCurrentForm = old('subscription_source') === $source;
    $hasError = $isCurrentForm && $errors->has('subscription_email');
@endphp

<form method="POST" action="{{ route('newsletter.store') }}" class="space-y-3" data-newsletter-form>
    @csrf
    <input type="hidden" name="subscription_source" value="{{ $source }}">
    <div class="absolute -left-[9999px]" aria-hidden="true">
        <label for="{{ $formId }}-website">No completes este campo</label>
        <input id="{{ $formId }}-website" name="website" type="text" tabindex="-1" autocomplete="off">
    </div>
    <label for="{{ $formId }}-email" class="sr-only">Tu email</label>
    <div class="flex flex-col gap-2 sm:flex-row">
        <input id="{{ $formId }}-email"
               class="campo min-w-0 flex-1 {{ $dark ? '!border-azul-700' : '' }}"
               type="email"
               name="subscription_email"
               value="{{ $isCurrentForm ? old('subscription_email') : '' }}"
               placeholder="nombre@taller.com"
               autocomplete="email"
               maxlength="254"
               @if ($hasError) aria-invalid="true" aria-describedby="{{ $formId }}-error" @endif
               required>
        <button type="submit" class="boton {{ $dark ? 'boton-claro' : 'boton-secundario' }} shrink-0">
            Recibir guías
        </button>
    </div>
    @if ($hasError)
        <p id="{{ $formId }}-error" class="t-cuerpo-chico {{ $dark ? 'text-white' : 'text-error' }}" role="alert">{{ $errors->first('subscription_email') }}</p>
    @endif
    <p class="t-cuerpo-chico {{ $dark ? 'text-azul-100' : 'text-texto-secundario' }}">
        Un email por mes. Podés darte de baja cuando quieras.
        <a href="{{ route('privacidad') }}" class="underline underline-offset-2 {{ $dark ? 'hover:text-white' : 'hover:text-azul-800' }}">Privacidad</a>.
    </p>
</form>

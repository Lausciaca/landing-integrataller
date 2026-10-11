@php
    $dark = $dark ?? false;
    $source = $source ?? 'inline';
    $formId = 'newsletter-' . $source;
    $isCurrentForm = old('subscription_source') === $source;
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
               class="input min-w-0 flex-1 {{ $dark ? 'border-white/25 bg-white text-secondary' : '' }}"
               type="email"
               name="subscription_email"
               value="{{ $isCurrentForm ? old('subscription_email') : '' }}"
               placeholder="nombre@taller.com"
               autocomplete="email"
               maxlength="254"
               required>
        <button type="submit" class="btn {{ $dark ? 'btn-light' : 'btn-primary' }} shrink-0">
            Recibir guías
        </button>
    </div>
    @if ($isCurrentForm && $errors->has('subscription_email'))
        <p class="text-sm {{ $dark ? 'text-amber-200' : 'text-danger' }}" role="alert">{{ $errors->first('subscription_email') }}</p>
    @endif
    <p class="text-xs leading-relaxed {{ $dark ? 'text-white/70' : 'text-secondary/70' }}">
        Un email mensual con guías y novedades. Confirmás la suscripción por correo y podés darte de baja cuando quieras.
        <a href="{{ route('privacidad') }}" class="underline underline-offset-2">Privacidad</a>.
    </p>
</form>

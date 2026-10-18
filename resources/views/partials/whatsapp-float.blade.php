@php
    $whatsapp = 'https://wa.me/' . config('landing.whatsapp') . '?text=' . rawurlencode(config('landing.whatsapp_message'));
@endphp

{{-- Botón flotante solo en celular. El verde WhatsApp es la única excepción de color del manual. --}}
<a href="{{ $whatsapp }}"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Escribinos por WhatsApp"
   class="fixed bottom-4 right-4 z-[200] inline-flex h-14 w-14 items-center justify-center rounded-full bg-whatsapp text-whatsapp-texto shadow-3 md:hidden">
    <x-icon name="whatsapp" class="h-7 w-7" />
</a>

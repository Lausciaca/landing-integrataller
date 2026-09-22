@php
    $whatsapp = 'https://wa.me/' . config('landing.whatsapp') . '?text=' . rawurlencode(config('landing.whatsapp_message'));
@endphp

<a href="{{ $whatsapp }}"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Escribinos por WhatsApp"
   class="fixed bottom-5 right-5 z-[200] inline-flex items-center gap-2 rounded-full bg-surface px-4 py-3.5 font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:scale-105 hover:bg-surface-dark"
   style="box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
    <x-icon name="whatsapp" class="h-7 w-7" />
    <span class="hidden pr-1 text-base lg:inline">WhatsApp</span>
</a>

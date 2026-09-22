@props(['tone' => 'dark', 'class' => 'h-9'])

@if ($tone === 'light')
    <span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>
        <img src="{{ asset('isotipo-128.png') }}"
             alt=""
             aria-hidden="true"
             width="128" height="128"
             decoding="async" loading="lazy"
             class="{{ $class }} w-auto shrink-0">
        <span class="font-display text-xl font-black leading-none tracking-tight text-white">
            Integra<span class="text-primary">Taller</span>
        </span>
    </span>
@elseif ($tone === 'mark')
    <img src="{{ asset('isotipo-128.png') }}"
         alt="IntegraTaller"
         width="128" height="128"
         decoding="async"
         {{ $attributes->merge(['class' => $class . ' w-auto']) }}>
@else
    <img src="{{ asset('logotipo-320.png') }}"
         alt="IntegraTaller"
         width="320" height="83"
         decoding="async"
         {{ $attributes->merge(['class' => $class . ' w-auto']) }}>
@endif

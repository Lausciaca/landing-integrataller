@props(['tone' => 'dark', 'class' => 'h-9'])

@if ($tone === 'light')
    <img src="{{ asset('logotipo-320.png') }}"
         alt="IntegraTaller"
         width="320" height="83"
         decoding="async" loading="lazy"
         {{ $attributes->merge(['class' => $class . ' w-auto brightness-0 invert']) }}>
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

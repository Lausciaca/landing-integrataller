{{--
    Video con carga diferida: un .mp4 propio (preload="none" y póster) o YouTube,
    que muestra el póster y recién al tocar carga el reproductor (resources/js/app.js).
    Sin JS, el enlace abre el video en YouTube.
--}}
@php
    $title ??= 'Video: cómo funciona IntegraTaller';
    $poster = filled($poster ?? null) ? (str_starts_with($poster, 'http') ? $poster : asset($poster)) : null;
    preg_match('~(?:youtu\.be/|youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/))([A-Za-z0-9_-]{11})~', (string) $url, $match);
    $youtube = $match[1] ?? null;
@endphp

<div data-revelar class="mx-auto mt-12 max-w-[920px] overflow-hidden rounded-xl bg-azul-900 shadow-3 md:mt-16">
    @if ($youtube)
        <a href="https://www.youtube.com/watch?v={{ $youtube }}" target="_blank" rel="noopener noreferrer"
           class="group relative block aspect-video" data-video-youtube="{{ $youtube }}" data-video-title="{{ $title }}" data-cta="video">
            @if ($poster)
                <img src="{{ $poster }}" alt="" width="1440" height="900" loading="lazy" decoding="async" class="h-full w-full object-cover opacity-80 transition-opacity group-hover:opacity-100">
            @endif
            <span class="absolute inset-0 flex items-center justify-center">
                <span class="inline-flex items-center gap-3 rounded-full bg-white px-5 py-3 font-medium text-azul-800 shadow-3">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
                    {{ $title }}
                </span>
            </span>
        </a>
    @else
        <video controls preload="none" playsinline class="block aspect-video w-full" width="1440" height="900"
               @if ($poster) poster="{{ $poster }}" @endif aria-label="{{ $title }}">
            <source src="{{ $url }}" type="video/mp4">
        </video>
    @endif
</div>

@php
    $analytics = config('landing.analytics');
    $tags = array_filter([
        'pixel' => $analytics['meta_pixel_id'] ?? null,
        'clarity' => $analytics['clarity_id'] ?? null,
        'ga4' => $analytics['ga4_id'] ?? null,
    ]);
    $payload = [
        'tags' => (object) $tags,
        'consentVersion' => (int) config('landing.cookie_consent_version', 1),
        'conversion' => session('conversion'),
    ];
@endphp

<script type="application/json" id="it-analytics">@json($payload)</script>

@if ($tags)
    @include('partials.cookie-consent', ['tags' => $tags])
@endif

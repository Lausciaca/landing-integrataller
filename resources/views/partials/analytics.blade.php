@php
    $analytics = config('landing.analytics');
    $tags = array_filter([
        'pixel' => $analytics['meta_pixel_id'] ?? null,
        'clarity' => $analytics['clarity_id'] ?? null,
        'ga4' => $analytics['ga4_id'] ?? null,
        'gads' => $analytics['google_ads_id'] ?? null,
    ]);
    $payload = [
        'tags' => (object) $tags,
        'consentVersion' => (int) config('landing.cookie_consent_version', 1),
        'gadsLeadLabel' => $analytics['google_ads_lead_label'] ?? null,
        'conversion' => session('conversion'),
    ];
@endphp

<script type="application/json" id="it-analytics">@json($payload)</script>

@if ($tags)
    @include('partials.cookie-consent', ['tags' => $tags])
@endif

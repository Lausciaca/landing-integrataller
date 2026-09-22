@php
    $organization = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => config('landing.site_name', 'IntegraTaller'),
        'url' => url('/'),
        'logo' => asset('logotipo.png'),
        'description' => 'Software de gestión para talleres mecánicos en Argentina.',
        'areaServed' => ['@type' => 'Country', 'name' => 'Argentina'],
        'contactPoint' => [[
            '@type' => 'ContactPoint',
            'telephone' => '+' . config('landing.whatsapp'),
            'contactType' => 'sales',
            'areaServed' => 'AR',
            'availableLanguage' => ['es'],
        ]],
    ];

    $social = array_values(array_filter((array) config('landing.social', [])));
    if ($social) {
        $organization['sameAs'] = $social;
    }

    $website = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => config('landing.site_name', 'IntegraTaller'),
        'url' => url('/'),
        'inLanguage' => 'es-AR',
    ];
@endphp

<script type="application/ld+json">{!! json_encode($organization, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($website, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

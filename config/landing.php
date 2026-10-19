<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Landing URLs
    |--------------------------------------------------------------------------
    |
    | Central configuration for the IntegraTaller marketing landing page.
    | The app URL points to the separate self-service cotizador.
    |
    */

    'app_url' => env('LANDING_APP_URL', 'https://app.integrataller.com/comenzar'),

    'whatsapp' => env('LANDING_WHATSAPP', '5493364006452'),

    'whatsapp_message' => env(
        'LANDING_WHATSAPP_MESSAGE',
        'Hola, quiero conocer IntegraTaller para mi taller.'
    ),

    'mercadopago_url' => env('LANDING_MERCADOPAGO_URL', 'https://www.mercadopago.com.ar'),

    'site_name' => 'IntegraTaller',

    'og_image' => env('LANDING_OG_IMAGE', 'og-image.png'),

    'demo_notification_email' => env('LANDING_DEMO_NOTIFICATION_EMAIL'),

    'marketing_consent_version' => '2026-10-v1',

    /*
    | Measurement. Third-party tags only load after cookie consent; the
    | first-party analytics is anonymous and cookie-free.
    */
    'analytics' => [
        'meta_pixel_id' => env('META_PIXEL_ID'),
        'meta_capi_token' => env('META_CAPI_TOKEN'),
        'meta_test_event_code' => env('META_TEST_EVENT_CODE'),
        'meta_graph_version' => env('META_GRAPH_VERSION', 'v24.0'),
        'clarity_id' => env('CLARITY_PROJECT_ID'),
        'ga4_id' => env('GA4_MEASUREMENT_ID'),
        'retention_days' => 90,
    ],

    // Bump to ask every visitor for cookie consent again.
    'cookie_consent_version' => 1,

    'social' => [
        // 'https://www.instagram.com/integrataller',
        // 'https://www.facebook.com/integrataller',
    ],

];

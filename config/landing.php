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

    'social' => [
        // 'https://www.instagram.com/integrataller',
        // 'https://www.facebook.com/integrataller',
    ],

];

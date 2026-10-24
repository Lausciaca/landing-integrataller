<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Landing URLs
    |--------------------------------------------------------------------------
    |
    | Central configuration for the IntegraTaller marketing landing page.
    | Quotes are only given through WhatsApp or the demo form.
    |
    */

    'whatsapp' => env('LANDING_WHATSAPP', '5493364006452'),

    'whatsapp_message' => env(
        'LANDING_WHATSAPP_MESSAGE',
        'Hola, quiero ver una demo de IntegraTaller para mi taller'
    ),

    'mercadopago_url' => env('LANDING_MERCADOPAGO_URL', 'https://www.mercadopago.com.ar'),

    'site_name' => 'IntegraTaller',

    'og_image' => env('LANDING_OG_IMAGE', 'og-image.png'),

    'demo_notification_email' => env('LANDING_DEMO_NOTIFICATION_EMAIL'),

    /*
    | SaaS (app.integrataller.com): de ahí salen los precios (GET
    | /api/planes-publicos), el alta autogestionada y el ingreso de clientes.
    */
    'saas_url' => rtrim((string) env('LANDING_SAAS_URL', 'https://app.integrataller.com'), '/'),

    /*
    | Respaldo si el SaaS no responde: mismos campos que /api/planes-publicos.
    | Vacío = sin respaldo (la sección de precios no se muestra hasta que el
    | SaaS vuelva). Ejemplo:
    |
    | 'pricing_fallback' => [
    |     'planes' => [[
    |         'nombre' => 'Pro', 'precio' => 0, 'descuento_pct' => 0, 'precio_final' => 0,
    |         'usuarios_incluidos' => 3, 'talleres_incluidos' => 1,
    |         'precio_usuario_extra' => 0, 'precio_taller_extra' => 0,
    |     ]],
    |     'prueba_dias' => 30,
    |     'transferencia_descuento_pct' => 0,
    | ],
    */
    // TODO-CONFIRMAR: cargar los precios de respaldo (los mismos del plan Pro en el panel de superadmin).
    'pricing_fallback' => [],

    /*
    | Textos pendientes de confirmar por el dueño. Están todos acá para
    | editarlos en un solo lugar; cada uno lleva su TODO-CONFIRMAR.
    */
    'copy' => [
        // TODO-CONFIRMAR: ¿se puede cancelar en cualquier momento, sin permanencia mínima?
        'pricing_trust_line' => 'Sin permanencia. Cancelás cuando quieras.',

        // TODO-CONFIRMAR: tiempo y horario reales de respuesta a los pedidos de demo.
        'response_time_text' => 'Te escribimos en menos de 2 horas, de lunes a sábado de 9 a 19.',
    ],

    // Agenda para elegir el horario de la demo (Google Calendar con horarios de cita o Calendly).
    // Vacío = la página de gracias no muestra el botón.
    'booking_url' => env('LANDING_BOOKING_URL'),

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
        // Google Ads: id "AW-…" and the label of the conversion action for demo requests.
        'google_ads_id' => env('GOOGLE_ADS_ID'),
        'google_ads_lead_label' => env('GOOGLE_ADS_LEAD_LABEL'),
        'retention_days' => 90,
    ],

    // Bump to ask every visitor for cookie consent again.
    'cookie_consent_version' => 1,

    'social' => [
        // 'https://www.instagram.com/integrataller',
        // 'https://www.facebook.com/integrataller',
    ],

];

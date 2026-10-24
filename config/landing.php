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

        // TODO-CONFIRMAR: "Sin permanencia" (va debajo de los botones de la portada y del cierre; en precios va pricing_trust_line).
        'risk_reversal' => '1 mes gratis. Sin permanencia. Cancelás cuando quieras.',

        // Preguntas frecuentes que dependen de definiciones del dueño.
        'faq' => [
            // TODO-CONFIRMAR: ¿hay contrato o permanencia mínima?
            'permanencia' => 'No. Pagás mes a mes y cancelás cuando quieras.',
            // TODO-CONFIRMAR: el dueño todavía no definió si el sistema emite factura electrónica de ARCA.
            'arca' => 'Escribinos por WhatsApp y te contamos cómo encaja la facturación de tu taller con IntegraTaller.',
            // TODO-CONFIRMAR: política de respaldos y de entrega de datos al darse de baja.
            // Verificado en el SaaS: el dueño descarga los movimientos de Finanzas y la cuenta corriente;
            // clientes, vehículos y órdenes se exportan en CSV desde el panel de IntegraTaller.
            'datos' => 'Tus datos son tuyos. Desde el sistema descargás los movimientos de caja y la cuenta corriente, y si los necesitás te pasamos tus clientes, vehículos y órdenes en una planilla.',
            // TODO-CONFIRMAR: qué pasa si se corta internet.
            'internet' => 'IntegraTaller funciona en la nube, así que necesita conexión. Si se corta internet en el taller, podés seguir desde el celular con datos móviles.',
        ],
    ],

    /*
    | Video de "Cómo funciona": un .mp4 propio o un enlace de YouTube. Vacío =
    | no se muestra. El póster es la imagen que se ve antes de reproducir.
    */
    // TODO-CONFIRMAR: falta grabar el video del recorrido.
    'video_url' => env('LANDING_VIDEO_URL'),
    'video_poster' => env('LANDING_VIDEO_POSTER', 'img/producto/panel-sucursales-escritorio.webp'),

    /*
    | Testimonios de la home. Solo datos reales y aprobados por el cliente.
    | Campos: quote, company, company_role, name (nombre y apellido), role
    | (cargo), size (sucursales o empleados), photo (ruta en public/, .webp)
    | y video_url (opcional, mp4 o YouTube).
    */
    'testimonials' => [
        [
            'quote' => 'Antes, para saber en qué estaba cada auto había que preguntar en el taller. Ahora lo veo en el celular antes de llegar.',
            'company' => 'Taller Sciaca',
            'company_role' => 'Servicios para automotores',
            // TODO-CONFIRMAR: falta la aprobación de Taller Sciaca para mostrar nombre, cargo, tamaño, foto y video.
            'name' => null,
            'role' => null,
            'size' => null,
            'photo' => null,
            'video_url' => null,
        ],
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

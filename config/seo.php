<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Programmatic SEO — Features
    |--------------------------------------------------------------------------
    |
    | Data-driven landing pages under /caracteristicas/{slug}. Add an entry
    | to publish a new page; it is automatically added to the sitemap.
    |
    */

    'features' => [
        'control-de-turnos' => [
            'label' => 'Control de turnos',
            'title' => 'Control de turnos para talleres mecánicos | IntegraTaller',
            'meta_description' => 'Organizá los turnos de tu taller sin superposiciones ni clientes esperando. Agenda, asigná mecánicos y avisá por WhatsApp.',
            'h1' => 'Gestión de turnos para tu taller, sin superposiciones',
            'pain' => 'Los turnos anotados en papel o en un grupo de WhatsApp se pisan, se olvidan y te hacen quedar mal con el cliente.',
            'solution' => 'Centralizá la agenda del taller: cada turno con patente, servicio, mecánico asignado y aviso automático al cliente.',
            'bullets' => [
                'Calendario por día y por mecánico',
                'Aviso de turno por WhatsApp',
                'Historial de servicios por vehículo',
            ],
        ],
        'historial-por-patente' => [
            'label' => 'Historial por patente',
            'title' => 'Historial de vehículos por patente | IntegraTaller',
            'meta_description' => 'Ingresá la patente y accedé al instante a todas las reparaciones previas, repuestos usados y diagnósticos del vehículo.',
            'h1' => 'Historial de vehículos por patente',
            'pain' => '¿Perdés horas buscando qué se le hizo a un auto hace 6 meses?',
            'solution' => 'Ingresá la patente y accedé al instante a todas las reparaciones previas, repuestos usados y diagnósticos de ese vehículo.',
            'bullets' => [
                'Ficha completa por vehículo',
                'Repuestos y diagnósticos registrados',
                'Búsqueda por patente en segundos',
            ],
        ],
        'control-de-stock' => [
            'label' => 'Control de stock',
            'title' => 'Control de stock de repuestos para talleres | IntegraTaller',
            'meta_description' => 'Controlá repuestos, aceite y filtros de tu taller. Alertas de bajo stock y descuento automático al cerrar cada orden de trabajo.',
            'h1' => 'Control de stock de repuestos para tu taller',
            'pain' => '¿Los repuestos se "pierden" o no sabés cuánto stock real tenés en el galpón?',
            'solution' => 'Descontá repuestos, aceite y filtros automáticamente con cada orden de trabajo cerrada, con alertas de bajo stock.',
            'bullets' => [
                'Descuento automático de stock',
                'Alertas de bajo stock',
                'Costos de lubricantes, filtros y piezas',
            ],
        ],
        'presupuestos-por-whatsapp' => [
            'label' => 'Presupuestos por WhatsApp',
            'title' => 'Presupuestos por WhatsApp para talleres | IntegraTaller',
            'meta_description' => 'Armá el presupuesto con tus costos y envialo al WhatsApp del cliente para que apruebe el trabajo en minutos.',
            'h1' => 'Presupuestos listos en 2 clics y por WhatsApp',
            'pain' => '¿Armar un presupuesto te frena el trabajo al final del día?',
            'solution' => 'Armá la cotización con tus costos y enviala directamente al WhatsApp de tu cliente para que apruebe el trabajo.',
            'bullets' => [
                'Cotización con tus propios costos',
                'Envío directo por WhatsApp',
                'Aprobación del cliente sin llamadas',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Programmatic SEO — Cities
    |--------------------------------------------------------------------------
    |
    | Local landing pages under /talleres-en-{ciudad}. Great for long-tail
    | local intent searches ("software para taller mecánico en Rosario").
    |
    */

    'cities' => [
        'rosario' => [
            'name' => 'Rosario',
            'province' => 'Santa Fe',
            'title' => 'Software para talleres mecánicos en Rosario | IntegraTaller',
            'meta_description' => 'Software de gestión para talleres mecánicos en Rosario: turnos, órdenes de trabajo, stock y presupuestos. Precios en pesos argentinos.',
            'h1' => 'Software de gestión para talleres mecánicos en Rosario',
            'intro' => 'Talleres de Rosario y la región ya ordenan sus turnos, stock y presupuestos con IntegraTaller. Activá tu sistema en el día, sin instalar nada.',
        ],
        'cordoba' => [
            'name' => 'Córdoba',
            'province' => 'Córdoba',
            'title' => 'Software para talleres mecánicos en Córdoba | IntegraTaller',
            'meta_description' => 'Software de gestión para talleres mecánicos en Córdoba: turnos, órdenes de trabajo, stock y presupuestos. Precios en pesos argentinos.',
            'h1' => 'Software de gestión para talleres mecánicos en Córdoba',
            'intro' => 'Talleres de Córdoba capital y el interior ya gestionan su día a día con IntegraTaller. Empezá a cargar tus turnos al instante.',
        ],
        'buenos-aires' => [
            'name' => 'Buenos Aires',
            'province' => 'Buenos Aires',
            'title' => 'Software para talleres mecánicos en Buenos Aires | IntegraTaller',
            'meta_description' => 'Software de gestión para talleres mecánicos en Buenos Aires (CABA y GBA): turnos, órdenes, stock y presupuestos. Precios en pesos.',
            'h1' => 'Software de gestión para talleres mecánicos en Buenos Aires',
            'intro' => 'Talleres de CABA y Gran Buenos Aires gestionan turnos, repuestos y caja con IntegraTaller. Sin instalaciones y con soporte por WhatsApp.',
        ],
    ],

];

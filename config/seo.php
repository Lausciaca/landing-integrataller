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
            'meta_description' => 'Organizá los turnos de tu taller con la semana a la vista: cada turno ligado a su orden y recordatorio al cliente por WhatsApp con un toque.',
            'h1' => 'Gestión de turnos para tu taller, con la semana a la vista',
            'pain' => 'Los turnos anotados en papel o en un grupo de WhatsApp se pisan, se olvidan y te hacen quedar mal con el cliente.',
            'solution' => 'Centralizá la agenda del taller: cada turno ligado a su orden, con patente y servicio, y el recordatorio al cliente por WhatsApp con un toque o por email automático.',
            'bullets' => [
                'Agenda de la semana, día por día',
                'Recordatorio por WhatsApp con un toque o por email automático',
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
            'meta_description' => 'Controlá repuestos, aceite y filtros de tu taller. Alertas de bajo stock y descuento del stock al cargar cada repuesto en la orden de trabajo.',
            'h1' => 'Control de stock de repuestos para tu taller',
            'pain' => '¿Los repuestos se "pierden" o no sabés cuánto stock real tenés en el galpón?',
            'solution' => 'Cada repuesto, aceite o filtro que cargás en una orden se descuenta del stock, y el tablero te avisa cuando algo queda por debajo del mínimo.',
            'bullets' => [
                'Descuento de stock al cargar el repuesto en la orden',
                'Alertas de bajo stock',
                'Costos de lubricantes, filtros y piezas',
            ],
        ],
        'presupuestos-por-whatsapp' => [
            'label' => 'Presupuestos por WhatsApp',
            'title' => 'Presupuestos por WhatsApp para talleres | IntegraTaller',
            'meta_description' => 'Armá el presupuesto y mandalo al WhatsApp del cliente con un toque: le llega el link al PDF y, cuando te dice que sí, lo aprobás en el sistema.',
            'h1' => 'Presupuestos que salen por WhatsApp en el momento',
            'pain' => '¿Armar un presupuesto te frena el trabajo al final del día?',
            'solution' => 'Armá la cotización y mandala al WhatsApp de tu cliente con un toque. Le llega el link al PDF y, cuando te responde que sí, lo aprobás y el trabajo queda listo para cobrar.',
            'bullets' => [
                'Cotización con tus propios costos',
                'Envío directo por WhatsApp',
                'Aprobación con un toque cuando el cliente responde',
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
            'intro' => 'Para talleres de Rosario y la región que quieren ordenar turnos, stock y presupuestos. Activá tu sistema en el día, sin instalar nada.',
        ],
        'cordoba' => [
            'name' => 'Córdoba',
            'province' => 'Córdoba',
            'title' => 'Software para talleres mecánicos en Córdoba | IntegraTaller',
            'meta_description' => 'Software de gestión para talleres mecánicos en Córdoba: turnos, órdenes de trabajo, stock y presupuestos. Precios en pesos argentinos.',
            'h1' => 'Software de gestión para talleres mecánicos en Córdoba',
            'intro' => 'Para talleres de Córdoba capital y el interior que quieren gestionar su día a día en un solo sistema. Empezá a cargar tus turnos al instante.',
        ],
        'buenos-aires' => [
            'name' => 'Buenos Aires',
            'province' => 'Buenos Aires',
            'title' => 'Software para talleres mecánicos en Buenos Aires | IntegraTaller',
            'meta_description' => 'Software de gestión para talleres mecánicos en Buenos Aires (CABA y GBA): turnos, órdenes, stock y presupuestos. Precios en pesos.',
            'h1' => 'Software de gestión para talleres mecánicos en Buenos Aires',
            'intro' => 'Para talleres de CABA y Gran Buenos Aires que quieren tener turnos, repuestos y caja en un solo lugar. Sin instalaciones y con soporte por WhatsApp.',
        ],
    ],

];

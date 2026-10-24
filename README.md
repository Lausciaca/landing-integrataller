# Landing de IntegraTaller

Sitio público de [integrataller.com](https://integrataller.com): Laravel 12 + Blade + Tailwind v4 + Vite.
El JS vive en `resources/js/app.js` (menú, diálogo de demo, formularios) y `resources/js/analytics.js`
(medición propia y etiquetas con consentimiento).

- Textos y datos editables: `config/landing.php`. Los textos que el dueño todavía tiene que confirmar
  están marcados con `TODO-CONFIRMAR` y agrupados en `copy`.
- Integración con la app administrativa (leads, suscriptores y analítica): [LEAD_SYNC.md](LEAD_SYNC.md).

## Desarrollo

```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
php artisan migrate
npm run dev        # o npm run build
php artisan test
```

## Puesta en producción

Variables que **tienen** que estar cargadas:

| Variable | Para qué |
| --- | --- |
| `LANDING_DEMO_NOTIFICATION_EMAIL` | Email que recibe el aviso de cada pedido de demo. **Obligatoria**: si está vacía, el aviso no se envía y el lead queda esperando. Requiere también un `MAIL_MAILER` real (no `log`) y `MAIL_FROM_ADDRESS`. |
| `LANDING_SAAS_URL` | URL del SaaS (por ejemplo `https://app.integrataller.com`). De ahí salen los precios (`/api/planes-publicos`), el alta "Probá 1 mes gratis" (`/auth/google/redirect`) y el enlace "Ingresar" (`/login`). |
| `LANDING_API_TOKEN` y `LANDING_SAAS_WEBHOOK_URL` | Sincronización con la app administrativa (ver LEAD_SYNC.md). |

Opcionales:

| Variable | Para qué |
| --- | --- |
| `LANDING_BOOKING_URL` | Agenda para elegir el horario de la demo (Google Calendar con horarios de cita o Calendly). Si tiene valor, la página de gracias muestra "Elegí el horario de tu demo". |
| `TELEGRAM_BOT_TOKEN` y `TELEGRAM_CHAT_ID` | Aviso inmediato de cada demo por Telegram con nombre, WhatsApp clickeable, sucursales y fuente/UTM. Se crea el bot con @BotFather; el chat id sale de `https://api.telegram.org/bot<token>/getUpdates` después de escribirle al bot. Sin las dos variables no se envía nada. |
| `META_PIXEL_ID`, `META_CAPI_TOKEN`, `META_TEST_EVENT_CODE`, `CLARITY_PROJECT_ID`, `GA4_MEASUREMENT_ID`, `GOOGLE_ADS_ID`, `GOOGLE_ADS_LEAD_LABEL` | Medición (solo con consentimiento de cookies). |

Después de cambiar variables: `php artisan config:cache`.

Los avisos (email, Telegram, app administrativa y Meta) se envían después de responder al visitante;
un error queda en el log y nunca rompe el formulario.

## Precios

La sección de precios muestra un precio fijo por plan (sin costo por sucursal ni por usuario). Lee los planes del SaaS y los guarda en caché una hora (`php artisan cache:forget planes-publicos`
para verlos al instante). Si el SaaS no responde usa `landing.pricing_fallback`; sin respaldo, la sección no se muestra.

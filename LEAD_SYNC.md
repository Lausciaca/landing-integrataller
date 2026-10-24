# API de contactos para la app administrativa

La app administrativa debe consultar esta landing por HTTPS. La landing conserva la base de datos y el consentimiento; la app administrativa importa los registros, administra sus listas y envía las campañas.

## Preparación en la landing

1. Aplicar las migraciones: `php artisan migrate --force`.
2. Generar un secreto aleatorio: `php -r 'echo bin2hex(random_bytes(32)), PHP_EOL;'`.
3. Configurar ese valor como `LANDING_API_TOKEN` en el entorno de la landing y, con el mismo valor, como secreto del cliente en la app administrativa. No guardar el secreto en Git ni enviarlo desde JavaScript.
4. Confirmar que la landing se sirve por HTTPS.
5. Configurar `LANDING_SAAS_WEBHOOK_URL` con el endpoint de aviso de la app administrativa (por ejemplo `https://app.integrataller.com/webhooks/landing`) y ejecutar `php artisan config:cache`.

La API queda en:

```text
https://integrataller.com/api/v1/landing
```

Todas las rutas requieren `Authorization: Bearer <LANDING_API_TOKEN>`. Si la variable no está configurada, responden `503`; con un token incorrecto, `401`. El límite es de 60 solicitudes por minuto.

## Endpoints

### `GET /demo-requests`

Devuelve solicitudes de demo con `id`, `name`, `workshop`, `branches`, `phone`, `email`, `message`, `status`, `marketing_opt_in_requested`, `source`, `created_at` y `updated_at`.

El formulario de demo es corto: solo son obligatorios `name`, `phone` (WhatsApp) y `branches` (`1`, `2`, `3` o `4+`). `workshop` y `email` pueden venir en `null`, y `message` siempre empieza con la cantidad de sucursales (por ejemplo, `Sucursales: 4 o más`).

`marketing_opt_in_requested` solo registra que se marcó la casilla en el formulario de demo. **No es consentimiento confirmado ni habilita campañas.** La lista autorizada para marketing está en el endpoint de suscriptores.

### `GET /newsletter-subscribers`

Devuelve `id`, `email`, `status`, `source`, `consent_version`, `consented_at`, `confirmed_at`, `unsubscribed_at`, `created_at` y `updated_at`. Los estados son `pending`, `active` y `unsubscribed`. La landing nunca entrega hashes de confirmación ni tokens de baja.

Se puede filtrar con `status=pending`, `status=active` o `status=unsubscribed`; sin filtro devuelve todos los estados para permitir mantener sincronizada la lista de supresión.

**Enviar campañas únicamente a registros con `status=active` y `confirmed_at` informado.** Mantener `pending` fuera de campañas y respetar siempre `unsubscribed`.

### `PUT /newsletter-subscribers/{id}/unsubscribe`

La app administrativa debe llamar este endpoint cuando alguien se dé de baja desde sus campañas. La operación es idempotente: una baja repetida responde correctamente sin crear cambios adicionales. La baja queda visible en la siguiente consulta incremental.

### `GET /analytics-events`

Eventos de la analítica propia (anónima, sin cookies ni IP). Son de solo agregado, así que se leen por id: `after_id` (último id recibido, por defecto 0) y `limit` (1 a 1000, por defecto 500). Mientras `pagination.has_more` sea `true`, pedir de nuevo con `after_id=pagination.last_id`.

Cada evento trae `id`, `occurred_at`, `session_id`, `visitor_hash` (rota cada día), `type`, `path`, `landing_page`, `referrer_host`, `utm_*`, `click_id` (`fbclid`/`gclid`), `device`, `browser`, `os`, `label` y `value`. Tipos: `pageview`, `cta_click`, `whatsapp_click`, `signup_click` (clic en "Probá 1 mes gratis", que lleva al alta del SaaS), `form_start`, `form_error`, `scroll` (value = 25/50/75/100), `engagement` (value = segundos visibles), `demo_submit` y `newsletter_submit`. La respuesta incluye `tags` con las etiquetas configuradas (Meta Pixel, Conversions API, Clarity, GA4). La landing borra los eventos de más de 90 días.

`GET /demo-requests` incluye además `attribution` (sesión, página de entrada, referente, UTM y click id) de cada solicitud.

## Paginación e importación incremental

Ambos `GET` aceptan:

- `limit`: entre 1 y 100; por defecto 100.
- `updated_since`: traer registros modificados desde ese instante, inclusive.
- `sync_until`: límite superior fijo para recorrer todas las páginas de una sincronización.
- `cursor`: cursor opaco devuelto en la página anterior.

Primera página:

```bash
curl --get 'https://integrataller.com/api/v1/landing/demo-requests' \
  --header "Authorization: Bearer $LANDING_API_TOKEN" \
  --header 'Accept: application/json' \
  --data-urlencode 'limit=100'
```

La respuesta tiene esta forma:

```json
{
  "data": [],
  "pagination": {
    "limit": 100,
    "has_more": false,
    "next_cursor": null,
    "updated_since": null,
    "sync_until": "2026-10-11T12:00:00+00:00"
  }
}
```

Si `has_more` es `true`, pedir la página siguiente pasando **el mismo** `sync_until` y el `next_cursor` recibido:

```bash
curl --get 'https://integrataller.com/api/v1/landing/demo-requests' \
  --header "Authorization: Bearer $LANDING_API_TOKEN" \
  --header 'Accept: application/json' \
  --data-urlencode 'limit=100' \
  --data-urlencode "sync_until=$SYNC_UNTIL" \
  --data-urlencode "cursor=$NEXT_CURSOR"
```

Al terminar todas las páginas, guardar `sync_until` como marca de agua. En la próxima sincronización pasarlo como `updated_since`; procesar los registros con *upsert* usando el `id` de la landing. Los límites son inclusivos, así que el consumidor debe tolerar registros repetidos. Guardar la marca de agua solo al completar el lote.

Repetir el mismo protocolo para `/newsletter-subscribers`. Para sincronizar bajas, importar también los estados `unsubscribed` o procesar el cambio tras el `PUT`.

## Aviso instantáneo a la app administrativa

Para no esperar a la sincronización programada, la landing avisa a la app administrativa cada vez que:

- entra una solicitud de demo (`demo-request.created`);
- se crea, confirma o da de baja un suscriptor desde la landing (`newsletter-subscriber.updated`).

El aviso es un `POST` a `LANDING_SAAS_WEBHOOK_URL` con el mismo secreto como `Authorization: Bearer <LANDING_API_TOKEN>` y este cuerpo:

```json
{ "event": "demo-request.created", "id": 123 }
```

No lleva datos personales: la app administrativa responde `202` y lee los cambios por la API incremental. El aviso se envía después de responder al visitante, con 5 segundos de timeout, y un error solo queda en el log (sin el token). Si la variable está vacía no se envía nada y la app sigue sincronizando cada 15 minutos.

## Ejemplo de baja desde la app administrativa

```bash
curl --request PUT \
  'https://integrataller.com/api/v1/landing/newsletter-subscribers/123/unsubscribe' \
  --header "Authorization: Bearer $LANDING_API_TOKEN" \
  --header 'Accept: application/json'
```

## Instrucciones para la IA que implemente la otra app

> Integra el panel con la API de la landing definida en `https://integrataller.com/api/v1/landing`. Lee `GET /demo-requests` y `GET /newsletter-subscribers` usando `Authorization: Bearer <secreto configurado en el entorno>`. Implementa importación incremental con `sync_until`, `updated_since`, `cursor` y lotes de hasta 100; persiste el ID de origen y usa *upsert* para que las repeticiones no creen duplicados. Importa solicitudes de demo por separado de la lista de marketing. Envía campañas solo a suscriptores `active` con `confirmed_at`; conserva y respeta los estados `pending` y `unsubscribed`. Cada baja desde el panel debe ejecutar `PUT /newsletter-subscribers/{id}/unsubscribe` en la landing. No registres el token en logs, no lo expongas al navegador y no reactives contactos dados de baja durante la importación.

La landing seguirá enviando el correo de confirmación de suscripción y el aviso interno de solicitudes de demo. La app administrativa queda a cargo de administrar la lista y enviar los correos mensuales.

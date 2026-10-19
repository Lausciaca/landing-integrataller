<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

use function Illuminate\Support\defer;

/**
 * Avisa a la app administrativa que hay datos nuevos para que sincronice al
 * instante. El aviso no lleva datos personales: la app los lee luego por la
 * API autenticada. Se envía después de responder al visitante y un fallo
 * nunca afecta al formulario (la app igual sincroniza cada 15 minutos).
 */
class SaasNotifier
{
    public function notify(string $event, int $id): void
    {
        $url = (string) config('services.integrataller.webhook_url');
        $token = (string) config('services.integrataller.api_token');

        if ($url === '' || $token === '') {
            return;
        }

        defer(function () use ($url, $token, $event, $id): void {
            try {
                $response = Http::withToken($token)
                    ->acceptJson()
                    ->connectTimeout(3)
                    ->timeout(5)
                    ->post($url, ['event' => $event, 'id' => $id]);

                if (! $response->successful()) {
                    Log::warning('The admin app rejected the landing notification.', [
                        'event' => $event,
                        'status' => $response->status(),
                    ]);
                }
            } catch (Throwable $exception) {
                Log::warning('Could not notify the admin app.', [
                    'event' => $event,
                    'exception' => $exception::class,
                ]);
            }
        });
    }
}

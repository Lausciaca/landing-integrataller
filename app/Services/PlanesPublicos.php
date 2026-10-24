<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Precios de la home: los planes del SaaS (GET /api/planes-publicos), así lo
 * que el dueño edita en el panel de superadmin se refleja solo. Caché de una
 * hora; si el SaaS no responde se usa `landing.pricing_fallback` y, sin
 * respaldo, la sección de precios no se muestra.
 */
class PlanesPublicos
{
    public const CACHE_KEY = 'planes-publicos';

    /** Un fallo se recuerda 5 minutos para no demorar cada visita esperando al SaaS. */
    private const CACHE_FALLO = 'planes-publicos:fallo';

    /** @var array<string, mixed>|false|null */
    private array|false|null $memo = null;

    /**
     * Precio fijo por plan: sucursales y usuarios no suman.
     *
     * @return array{pro: array{nombre: string, precio: float, descuento_pct: float, precio_final: float}, corporation: ?array{nombre: string, precio: float, descuento_pct: float, precio_final: float}, prueba_dias: int, transferencia_descuento_pct: float}|null
     */
    public function datos(): ?array
    {
        if ($this->memo === null) {
            $this->memo = $this->normalizar($this->desdeSaas()) ?? $this->normalizar(config('landing.pricing_fallback')) ?? false;
        }

        return $this->memo ?: null;
    }

    private function desdeSaas(): ?array
    {
        if ($guardado = Cache::get(self::CACHE_KEY)) {
            return $guardado;
        }
        if (Cache::has(self::CACHE_FALLO)) {
            return null;
        }

        $url = config('landing.saas_url').'/api/planes-publicos';
        try {
            $respuesta = Http::acceptJson()->connectTimeout(2)->timeout(3)->get($url);
            $datos = $respuesta->successful() ? $respuesta->json() : null;
            if ($this->normalizar($datos)) {
                Cache::put(self::CACHE_KEY, $datos, now()->addHour());

                return $datos;
            }
            Log::warning('The SaaS public plans endpoint returned no usable data.', ['status' => $respuesta->status()]);
        } catch (Throwable $exception) {
            Log::warning('Could not reach the SaaS public plans endpoint.', ['exception' => $exception::class]);
        }

        Cache::put(self::CACHE_FALLO, true, now()->addMinutes(5));

        return null;
    }

    private function normalizar(mixed $datos): ?array
    {
        if (! is_array($datos) || ! is_array($datos['planes'] ?? null)) {
            return null;
        }

        $planes = collect($datos['planes'])->map(fn ($plan) => $this->plan($plan))->filter()->keyBy(fn ($plan) => mb_strtolower($plan['nombre']));
        if (! $planes->has('pro')) {
            return null;
        }

        return [
            'pro' => $planes->get('pro'),
            'corporation' => $planes->get('corporation'),
            'prueba_dias' => max(0, (int) ($datos['prueba_dias'] ?? 0)),
            'transferencia_descuento_pct' => max(0.0, min(100.0, (float) ($datos['transferencia_descuento_pct'] ?? 0))),
        ];
    }

    private function plan(mixed $plan): ?array
    {
        if (! is_array($plan) || ! is_string($plan['nombre'] ?? null) || ! is_numeric($plan['precio'] ?? null) || (float) $plan['precio'] <= 0) {
            return null;
        }

        $precio = (float) $plan['precio'];
        $descuento = max(0.0, min(100.0, (float) ($plan['descuento_pct'] ?? 0)));

        return [
            'nombre' => $plan['nombre'],
            'precio' => $precio,
            'descuento_pct' => $descuento,
            'precio_final' => is_numeric($plan['precio_final'] ?? null) ? (float) $plan['precio_final'] : round($precio * (1 - $descuento / 100), 2),
        ];
    }

    /** Pesos sin decimales, como Intl.NumberFormat('es-AR', ARS) en el navegador. */
    public static function pesos(float $monto): string
    {
        return "$\u{00A0}".number_format($monto, 0, ',', '.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Services\AnalyticsRecorder;
use App\Services\MetaConversions;
use App\Support\Attribution;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Receives the browser beacon (`navigator.sendBeacon`, text/plain JSON).
 * Always answers 204 so invalid payloads reveal nothing.
 */
class AnalyticsController extends Controller
{
    public function __invoke(Request $request, AnalyticsRecorder $recorder, MetaConversions $meta): Response
    {
        $raw = $request->getContent();
        $data = strlen($raw) <= 4096 ? json_decode($raw, true) : null;
        $type = is_array($data) ? ($data['t'] ?? null) : null;

        if (! in_array($type, AnalyticsEvent::CLIENT_TYPES, true)) {
            return response()->noContent();
        }

        $attribution = Attribution::sanitize(is_array($data['a'] ?? null) ? $data['a'] : []);
        $path = is_string($data['p'] ?? null) ? strtok($data['p'], '?#') : null;
        if (! $attribution['session_id'] || ! $path || ! str_starts_with($path, '/')) {
            return response()->noContent();
        }

        $event = $recorder->record($request, $type, $attribution, [
            'path' => $path,
            'width' => is_int($data['w'] ?? null) ? $data['w'] : null,
            'label' => is_string($data['l'] ?? null) ? trim($data['l']) : null,
            'value' => $this->value($type, $data['v'] ?? null),
        ]);

        $eventId = is_string($data['e'] ?? null) && preg_match('/^[A-Za-z0-9-]{8,64}$/', $data['e']) ? $data['e'] : null;
        if ($event && $type === 'whatsapp_click' && $eventId) {
            $meta->send($request, 'Contact', $eventId, url($path), ['fbclid' => $attribution['fbclid']]);
        }

        return response()->noContent();
    }

    private function value(string $type, mixed $value): ?int
    {
        if (! is_int($value)) {
            return null;
        }

        return match ($type) {
            'scroll' => in_array($value, [25, 50, 75, 100], true) ? $value : null,
            'engagement' => $value > 0 ? min($value, 3600) : null,
            default => null,
        };
    }
}

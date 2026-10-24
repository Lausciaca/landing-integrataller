<?php

namespace App\Services;

use App\Models\Contact;
use App\Support\Telefono;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

use function Illuminate\Support\defer;

/**
 * Aviso inmediato de cada pedido de demo por Telegram, para responder
 * rápido desde el celular: nombre, WhatsApp clickeable, sucursales y fuente.
 * Opcional (TELEGRAM_BOT_TOKEN y TELEGRAM_CHAT_ID). Se envía después de
 * responder al visitante y un error nunca afecta al formulario.
 */
class TelegramNotifier
{
    public function enabled(): bool
    {
        return filled(config('services.telegram.bot_token')) && filled(config('services.telegram.chat_id'));
    }

    public function demoRequest(Contact $contact): void
    {
        if (! $this->enabled()) {
            return;
        }

        $token = (string) config('services.telegram.bot_token');
        $payload = [
            'chat_id' => (string) config('services.telegram.chat_id'),
            'text' => $this->message($contact),
            'parse_mode' => 'HTML',
            'link_preview_options' => ['is_disabled' => true],
        ];

        defer(function () use ($token, $payload, $contact): void {
            try {
                $response = Http::asJson()->connectTimeout(3)->timeout(5)
                    ->post('https://api.telegram.org/bot'.$token.'/sendMessage', $payload);

                if (! $response->successful()) {
                    Log::warning('Telegram rejected the demo request notification.', [
                        'contact_id' => $contact->id,
                        'status' => $response->status(),
                    ]);
                }
            } catch (Throwable $exception) {
                Log::warning('Could not send the demo request notification to Telegram.', [
                    'contact_id' => $contact->id,
                    'exception' => $exception::class,
                ]);
            }
        });
    }

    private function message(Contact $contact): string
    {
        $e = fn (?string $text) => htmlspecialchars((string) $text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $number = Telefono::e164($contact->phone);
        $whatsapp = $number
            ? '<a href="https://wa.me/'.$number.'">'.$e($contact->phone).'</a> (wa.me/'.$number.')'
            : $e($contact->phone);

        $utm = collect(['utm_source', 'utm_medium', 'utm_campaign', 'utm_content'])
            ->map(fn ($key) => $contact->{$key})
            ->filter()
            ->join(' / ');
        $source = $utm !== '' ? $utm : ($contact->referrer_host ?: 'Directo');

        return collect([
            '<b>Nuevo pedido de demo</b>',
            'Nombre: '.$e($contact->name),
            'WhatsApp: '.$whatsapp,
            'Sucursales: '.$e(Contact::BRANCHES[$contact->branches] ?? $contact->branches),
            $contact->taller ? 'Taller: '.$e($contact->taller) : null,
            'Fuente: '.$e($source),
            $contact->landing_page ? 'Entró por: '.$e($contact->landing_page) : null,
        ])->filter()->join("\n");
    }
}

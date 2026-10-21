<?php

namespace App\Support;

/**
 * wa.me link to the IntegraTaller WhatsApp with a ready-made message, so
 * every button opens the same conversation.
 */
final class WhatsApp
{
    public static function url(?string $text = null): string
    {
        $text ??= (string) config('landing.whatsapp_message');

        return 'https://wa.me/'.config('landing.whatsapp').'?text='.rawurlencode($text);
    }
}

<?php

use App\Models\AnalyticsEvent;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Visitas de Meta (fbclid o utm_source de Meta) que llegaron sin utm_campaign: para ver qué anuncio o enlace las trae.
Artisan::command('analytics:meta-sin-campana {--days=14 : Días hacia atrás}', function () {
    $sessions = AnalyticsEvent::query()
        ->where('type', 'pageview')
        ->where('occurred_at', '>=', now()->subDays((int) $this->option('days')))
        ->whereNull('utm_campaign')
        ->where(fn ($query) => $query
            ->where('click_id', 'fbclid')
            ->orWhereIn(DB::raw('LOWER(utm_source)'), ['facebook', 'fb', 'instagram', 'ig', 'meta', 'messenger']))
        ->orderBy('occurred_at')
        ->get()
        ->unique('session_id');

    $this->table(
        ['Fecha', 'Entrada', 'Referente', 'utm_source', 'utm_medium', 'Click id', 'Navegador', 'Sistema'],
        $sessions->map(fn (AnalyticsEvent $event) => [
            $event->occurred_at->setTimezone('America/Argentina/Buenos_Aires')->format('d/m H:i'),
            $event->landing_page, $event->referrer_host, $event->utm_source, $event->utm_medium,
            $event->click_id, $event->browser, $event->os,
        ]),
    );
    $this->info($sessions->count().' sesiones de Meta sin campaña.');
})->purpose('Lista las visitas de Meta que llegaron sin utm_campaign');

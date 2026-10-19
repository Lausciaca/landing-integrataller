<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsEvent extends Model
{
    /** Events sent by the browser beacon. */
    public const CLIENT_TYPES = ['pageview', 'cta_click', 'whatsapp_click', 'form_start', 'scroll', 'engagement'];

    /** Conversions recorded by the server once the form is accepted. */
    public const SERVER_TYPES = ['demo_submit', 'newsletter_submit'];

    public const ATTRIBUTION = [
        'landing_page', 'referrer_host', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'click_id',
    ];

    public $timestamps = false;

    protected $fillable = [
        'occurred_at', 'session_id', 'visitor_hash', 'type', 'path', 'landing_page', 'referrer_host',
        'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'click_id',
        'device', 'browser', 'os', 'label', 'value',
    ];

    protected function casts(): array
    {
        return [
            'occurred_at' => 'immutable_datetime',
            'value' => 'integer',
        ];
    }
}

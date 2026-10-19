<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'taller',
        'phone',
        'email',
        'message',
        'status',
        'marketing_opt_in_requested',
        'source',
        'session_id',
        'landing_page',
        'referrer_host',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'utm_term',
        'click_id',
        'meta_event_id',
    ];
}

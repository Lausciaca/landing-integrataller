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
    ];
}

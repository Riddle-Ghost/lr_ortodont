<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    public const STATUS_NEW = 0;
    public const STATUS_MAILED = 1;

    protected $fillable = [
        'message',
        'short_message',
        'to_email',
        'to_db',
        'min_balance',
        'max_balance',
        'roles',
        'status',
        'mailed_at',
        'created_from',
        'created_to',
    ];

    protected $dates = [
        'mailed_at',
        'created_from',
        'created_to',
    ];

    protected $casts = [
        'roles' => 'array',
    ];
}

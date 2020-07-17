<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'merchant',
        'merchant_id',
        'status',
        'comment',
    ];

    public const STATUS_NEW = 0;
    public const STATUS_WAITING = 1;
    public const STATUS_CONFIRMED = 2;
    public const STATUS_ERROR = 3;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function new($user_id, $sum)
    {
        return self::create([
            'user_id' => $user_id,
            'amount' => $sum,
            'merchant' => config('payment.activeMerchant'),
            'status' => Payment::STATUS_NEW,
            'comment' => '',
        ]);
    }
}

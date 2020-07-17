<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class PaymentAccepted
{
    use SerializesModels;

    public $user;
    public $amount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, int $amount)
    {
        $this->user = $user;
        $this->amount = $amount;
    }
}

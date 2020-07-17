<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\PaymentAccepted;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PaymentAcceptedNotification;

class PaymentAcceptedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaymentAccepted  $event
     * @return void
     */
    public function handle(PaymentAccepted $event)
    {
        $users = User::admins()->get();
        $users->push($event->user);
        Notification::send($users, new PaymentAcceptedNotification($event->amount));
    }
}

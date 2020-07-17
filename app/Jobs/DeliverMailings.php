<?php

namespace App\Jobs;

use App\Models\Game;
use App\Models\Mailing;
use App\Models\User;
use App\Notifications\MailingNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class DeliverMailings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600;

    public $mailing;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Mailing $mailing)
    {
        $this->mailing = $mailing;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $query = User::where('id', '>', 0);

        if ($this->mailing->min_balance > 0) {
            $query->where('balance', '>=', $this->mailing->min_balance);
        }

        if ($this->mailing->max_balance > 0) {
            $query->where('balance', '<=', $this->mailing->max_balance);
        }

        if ($this->mailing->created_from) {
            $query->where('created_at', '>=', $this->mailing->created_from->startOfDay());
        }

        if ($this->mailing->created_to) {
            $query->where('created_at', '<=', $this->mailing->created_to->endOfDay());
        }

        if (!empty($this->mailing->roles)) {

            $query->where(function($query) {
                
                foreach ($this->mailing->roles as $role) {

                    $query->orWhere('role_id', $role);
                }
                
            });
        }

        $query->chunk(1000, function ($users) {
            Notification::send($users, (new MailingNotification($this->mailing)));
        });
    }
}

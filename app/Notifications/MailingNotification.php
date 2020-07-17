<?php

namespace App\Notifications;

use App\Models\Mailing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MailingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Mailing
     */
    var $mailing;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Mailing $mailing)
    {
        $this->mailing = $mailing;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        $where = [];

        if ($this->mailing->to_db && $this->mailing->short_message) {
            $where[] = 'database';
        }

        if ($this->mailing->to_email && $this->mailing->message) {
            $where[] = 'mail';
        }

        return $where;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Новое уведомление')
            ->greeting("Приветствуем, $notifiable->name");

        foreach (explode("\n", $this->mailing->message) as $line) {
            $mail->line($line);
        }

        $mail->action('Перейти на сайт', url('/'));

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'mailing_id' => $this->mailing->id,
            'text' => $this->mailing->short_message
        ];
    }
}

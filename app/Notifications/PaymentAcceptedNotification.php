<?php

namespace App\Notifications;

use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentAcceptedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    var $amount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        return $notifiable->role_id === Role::ADMIN_ID ? ['database'] : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Пополнение баланса')
            ->greeting("Приветствуем, $notifiable->name")
            ->line("На ваш баланс зачислено $this->amount ₽")
            ->action('Перейти на сайт', url('/'));
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
            'text' => "Платеж на $this->amount ₽ подтвержден"
        ];
    }
}

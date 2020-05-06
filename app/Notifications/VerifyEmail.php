<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use \Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyEmail extends VerifyEmailBase
{
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @param string $password
     * @return void
     */
    public function __construct(string $password = null)
    {
        $this->password = $password;
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
            ->from('no-reply@b2b.u-modno.ru', 'Улыбаться Модно') // TODO: Change address and name
            ->subject('Подтверждение электронной почты') // TODO: Change subject
            ->view('email.verify', [
                'verificationUrl'   => $verificationUrl,
                'password'          => $this->password
            ]);
    }
}

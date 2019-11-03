<?php

namespace App\Notifications;

use App\Traits\SmtpSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Config;

class ContactUsMail extends Notification
{
    use Queueable, SmtpSettings;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $fromEmail)
    {
        $this->data = $data;
        $this->setMailConfigs();
        Config::set('mail.from.address', $fromEmail);
    }

    /**
     * Get the notification's delivery channels.
     *t('mail::layout')
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['mail'];

        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Contact Us'.' '.config('app.name').'!')
            ->greeting(__('email.hello').' Admin !')
            ->markdown('vendor.notifications.contact-us', $this->data);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $notifiable->toArray();
    }
}

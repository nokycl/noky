<?php

namespace App\Notifications;

use App\EmailNotificationSetting;
use App\Invoice;
use App\Traits\SmtpSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use App\User;

class NewInvoice extends Notification implements ShouldQueue
{
    use Queueable, SmtpSettings;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $invoice;
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->emailSetting = EmailNotificationSetting::all();
        $this->setMailConfigs();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['database'];

        if($this->emailSetting[10]->send_email == 'yes'){
            array_push($via, 'mail');
        }

        if($this->emailSetting[10]->send_slack == 'yes'){
            array_push($via, 'slack');
        }

        if($this->emailSetting[10]->send_push == 'yes'){
            array_push($via, OneSignalChannel::class);
        }

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
        $url = route('client.invoices.index');

        return (new MailMessage)
            ->subject('New Invoice Generated!')
            ->greeting('Hello '.ucwords($notifiable->name).'!')
            ->line('A new invoice has been generated for you. Login now to view the invoice.')
            ->action('Login To Dashboard', $url);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->invoice->toArray();
    }
}

<?php

namespace App\Notifications;

use App\EmailNotificationSetting;
use App\Invoice;
use App\InvoiceSetting;
use App\Traits\SmtpSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvoicePaymentReceived extends Notification
{
    use Queueable, SmtpSettings;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $invoice;
    private $invoiceSetting;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->invoiceSetting = InvoiceSetting::first();
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

        if ($this->emailSetting[10]->send_email == 'yes') {
            array_push($via, 'mail');
        }

        if ($this->emailSetting[10]->send_slack == 'yes') {
            array_push($via, 'slack');
        }

        if ($this->emailSetting[10]->send_push == 'yes') {
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
        $url = route('admin.all-invoices.index');

        return (new MailMessage)
            ->subject(__('email.invoices.paymentReceived').' - '.config('app.name'))
            ->greeting(__('email.hello').' '.ucwords($notifiable->name).'!')
            ->line(__('email.invoices.paymentReceived').':- ')
            ->line($this->invoiceSetting->invoice_prefix . ' #' . $this->invoice->id)
            ->action(__('email.loginDashboard'), $url)
            ->line(__('email.thankyouNote'));
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

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Company;
use App\PaypalInvoice;
use App\Traits\SuperAdminSmtpSettings;

class CancelPaypalLicense extends Notification
{
    use Queueable, SuperAdminSmtpSettings;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Company $company, $invoiceId)
    {
        $this->company = $company;
        $this->paypalInvoice = PaypalInvoice::findOrFail($invoiceId);
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
        return ['mail'];
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
            ->subject(__('email.cancelLicense.subject').' '.config('app.name').'!')
            ->greeting(__('email.hello').' '.ucwords($notifiable->name).'!')
            ->line(__('email.cancelLicense.text'))
            ->line(__('modules.accountSettings.companyName').': '.$this->company->company_name)
            ->line(__('modules.payments.paidOn').': '.$this->paypalInvoice->paid_on->format('d M, Y').' (PayPal)')
            ->action(__('email.loginDashboard'), url('/'))
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
        return [
            //
        ];
    }
}

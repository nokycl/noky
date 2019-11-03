<?php

namespace App\Notifications;

use App\Company;
use App\Package;
use App\SlackSetting;
use App\Traits\SuperAdminSmtpSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CompanyUpdatedPlan extends Notification implements ShouldQueue
{
    use Queueable, SuperAdminSmtpSettings;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $company;
    private $package;

    public function __construct(Company $company, $packageID)
    {
        $this->company = $company;
        $this->package = Package::findOrFail($packageID);

        $this->setMailConfigs();
    }

    /**
     * Get the notification's delivery channels.
     *t('mail::layout')
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['database', 'mail'];

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
            ->subject(__('email.planUpdate.subject').' '.config('app.name').'!')
            ->greeting(__('email.hello').' '.ucwords($notifiable->name).'!')
            ->line(__($this->company->company_name.' '.'email.planUpdate.text').' '.$this->package->name)
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
        return array_merge($notifiable->toArray(), ['company_name' => $this->company->company_name, 'name' => $this->package->name]);
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $slack = SlackSetting::first();
        if(count($notifiable->employee) > 0 && !is_null($notifiable->employee[0]->slack_username)){
            return (new SlackMessage())
                ->from(config('app.name'))
                ->image(asset('storage/slack-logo/' . $slack->slack_logo))
                ->to('@' . $notifiable->employee[0]->slack_username)
                ->content('Welcome to ' . config('app.name') . '! New company has been registered.');
        }
        return (new SlackMessage())
            ->from(config('app.name'))
            ->image(asset('storage/slack-logo/' . $slack->slack_logo))
            ->content('This is a redirected notification. Add slack username for *'.ucwords($notifiable->name).'*');
    }

}

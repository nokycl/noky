<?php

namespace App\Notifications;

use App\EmailNotificationSetting;
use App\SlackSetting;
use App\Task;
use App\Traits\SmtpSettings;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class NewTask extends Notification implements ShouldQueue
{
    use Queueable, SmtpSettings;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $task;
    private $user;
    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->user = User::findOrFail($task->user_id);
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

        if ($this->emailSetting[7]->send_email == 'yes') {
            array_push($via, 'mail');
        }

        if ($this->emailSetting[7]->send_slack == 'yes') {
            array_push($via, 'slack');
        }

        if ($this->emailSetting[7]->send_push == 'yes') {
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
        $url = url('/');

        $content = ucfirst($this->task->heading) . '<p>
            <b style="color: green">Due On: ' . $this->task->due_date->format('d M, Y') . '</b>
        </p>';

        return (new MailMessage)
            ->subject(__('email.newTask.subject') . ' - ' . config('app.name') . '!')
            ->greeting(__('email.hello') . ' ' . ucwords($this->user->name) . '!')
            ->markdown('mail.task.created', ['url' => $url, 'content' => $content]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->task->toArray();
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
        if (count($notifiable->employee) > 0 && (!is_null($notifiable->employee[0]->slack_username) && ($notifiable->employee[0]->slack_username != ''))) {
            return (new SlackMessage())
                ->from(config('app.name'))
                ->image(asset('storage/slack-logo/' . $slack->slack_logo))
                ->to('@' . $notifiable->employee[0]->slack_username)
                ->content(__('email.newTask.subject'));
        }
        return (new SlackMessage())
            ->from(config('app.name'))
            ->image(asset('storage/slack-logo/' . $slack->slack_logo))
            ->content('This is a redirected notification. Add slack username for *' . ucwords($notifiable->name) . '*');
    }

    public function toOneSignal($notifiable)
    {
        return OneSignalMessage::create()
            ->subject(__('email.newTask.subject'))
            ->body($this->task->heading);
    }
}

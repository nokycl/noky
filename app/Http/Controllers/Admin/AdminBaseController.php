<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\EmailNotificationSetting;
use App\LanguageSetting;
use App\Notification;
use App\ProjectActivity;
use App\PushNotificationSetting;
use App\StickyNote;
use App\Traits\FileSystemSettingTrait;
use App\UniversalSearch;
use App\UserActivity;
use App\UserChat;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use App\ThemeSetting;
use Illuminate\Support\Facades\Auth;
use App\GlobalSetting;

class AdminBaseController extends Controller
{
    use FileSystemSettingTrait;

    /**
     * @var array
     */
    public $data = [];

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * UserBaseController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // Inject currently logged in user object into every view of user dashboard
        $this->middleware(function ($request, $next) {

            $this->global = $this->company = Company::with('currency')->withoutGlobalScope('active')->where('id', Auth::user()->company_id)->first();
          
            $this->superadmin = GlobalSetting::with('currency')->first();

            $this->emailSetting = EmailNotificationSetting::all();
            $this->pushSetting = PushNotificationSetting::first();
            $this->companyName = $this->global->company_name;

            $this->adminTheme = ThemeSetting::where('panel', 'admin')->first();
            $this->languageSettings = LanguageSetting::where('status', 'enabled')->get();

            App::setLocale($this->global->locale);
            Carbon::setLocale($this->global->locale);
            setlocale(LC_TIME, $this->global->locale . '_' . strtoupper($this->global->locale));
            $this->setFileSystemConfigs();


            $this->user = auth()->user();
            $this->modules = $this->user->modules;

            $this->unreadMessageCount = UserChat::where('to', $this->user->id)->where('message_seen', 'no')->count();
            $this->unreadTicketCount = Notification::where('notifiable_id', $this->user->id)
                ->where('type', 'App\Notifications\NewTicket')
                ->whereNull('read_at')
                ->count();

            $this->unreadExpenseCount = Notification::where('notifiable_id', $this->user->id)
                ->where('type', 'App\Notifications\NewExpenseAdmin')
                ->whereNull('read_at')
                ->count();

            $this->unreadIssuesCount = Notification::where('notifiable_id', $this->user->id)
                ->where('type', 'App\Notifications\NewIssue')
                ->whereNull('read_at')
                ->count();

            $this->stickyNotes = StickyNote::where('user_id', $this->user->id)
                ->orderBy('updated_at', 'desc')
                ->get();
            return $next($request);
        });
    }

    public function logProjectActivity($projectId, $text)
    {
        $activity = new ProjectActivity();
        $activity->project_id = $projectId;
        $activity->activity = $text;
        $activity->save();
    }

    public function logUserActivity($userId, $text)
    {
        $activity = new UserActivity();
        $activity->user_id = $userId;
        $activity->activity = $text;
        $activity->save();
    }

    public function logSearchEntry($searchableId, $title, $route)
    {
        $search = new UniversalSearch();
        $search->searchable_id = $searchableId;
        $search->title = $title;
        $search->route_name = $route;
        $search->save();
    }
}

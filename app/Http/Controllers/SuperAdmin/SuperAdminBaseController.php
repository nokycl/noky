<?php

namespace App\Http\Controllers\SuperAdmin;

use App\GlobalSetting;
use App\LanguageSetting;
use App\Traits\FileSystemSettingTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use App\PushNotificationSetting;

class SuperAdminBaseController extends Controller
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
        return isset($this->data[ $name ]);
    }

    /**
     * UserBaseController constructor.
     */
    public function __construct()
    {
        // Inject currently logged in user object into every view of user dashboard
        $this->global = GlobalSetting::with('currency')->first();

        App::setLocale($this->global->locale);
        Carbon::setLocale($this->global->locale);
        setlocale(LC_TIME, $this->global->locale . '_' . strtoupper($this->global->locale));

        $this->languageSettings = LanguageSetting::where('status', 'enabled')->get();
        $this->pushSetting = PushNotificationSetting::first();

        $this->middleware(function ($request, $next) {
            $this->user = $request->user();
            return $next($request);
        });
    }
}

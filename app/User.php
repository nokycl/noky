<?php

namespace App;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    protected static function boot()
    {
        parent::boot();

        static::observe(UserObserver::class);

        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('users.status', '=', 'active');
        });

        $company = company();
        
        static::addGlobalScope('company', function (Builder $builder) use ($company) {
            if ($company) {
                $builder->where('users.company_id', '=', $company->id);
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $dates = ['created_at', 'updated_at'];

    protected $appends = ['name', 'email', 'image', 'mobile'];


    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        $slack = SlackSetting::first();
        return $slack->slack_webhook;
    }

    public function routeNotificationForOneSignal()
    {
        return $this->onesignal_player_id;
    }

    public function client()
    {
        return $this->hasMany(ClientDetails::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function employee()
    {
        return $this->hasMany(EmployeeDetails::class, 'user_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function member()
    {
        return $this->hasMany(ProjectMember::class, 'user_id');
    }

    public function role()
    {
        return $this->hasMany(RoleUser::class, 'user_id');
    }

    public function attendee()
    {
        return $this->hasMany(EventAttendee::class, 'user_id');
    }

    public function agent()
    {
        return $this->hasMany(TicketAgentGroups::class, 'agent_id');
    }

    public function group()
    {
        return $this->hasMany(EmployeeTeam::class, 'user_id');
    }

    // public function company()
    // {
    //     return $this->belongsTo(Company::class);
    // }

    public function skills()
    {
        return EmployeeSkill::select('skills.name')->join('skills', 'skills.id', 'employee_skills.skill_id')->where('user_id', $this->id)->pluck('name')->toArray();
    }

    public static function allClients()
    {
        $clients = ClientDetails::join('users', 'client_details.user_id', '=', 'users.id')
            ->select('users.id', 'client_details.name', 'client_details.email', 'client_details.created_at')
            ->get();

        return $clients;
    }

    public static function allSuperAdmin()
    {
        return User::withoutGlobalScope('active')
            ->where('super_admin', '1')
            ->get();
    }

    public static function allEmployees($exceptId = null)
    {
        $users = User::withoutGlobalScope('active')->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name', 'users.email', 'users.created_at')
            ->where('roles.name', '<>', 'client');

        if (!is_null($exceptId)) {
            $users->where('users.id', '<>', $exceptId);
        }

        $users->groupBy('users.id');
        return $users->get();
    }

    public static function allAdmins($exceptId = null)
    {
        $users = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name', 'users.email', 'users.created_at')
            ->where('roles.name', 'admin');

        if (!is_null($exceptId)) {
            $users->where('users.id', '<>', $exceptId);
        }

        return $users->get();
    }

    public static function firstAdmin()
    {
        $users = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name', 'users.email', 'users.created_at')
            ->where('roles.name', 'admin')
            ->orderBy('users.id', 'asc');
        return $users->first();
    }

    public static function teamUsers($teamId)
    {
        $users = User::join('employee_teams', 'employee_teams.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'users.created_at')
            ->where('employee_teams.team_id', $teamId);

        return $users->get();
    }

    public static function userListLatest($userID, $term)
    {

        if ($term) {
            $termCnd = "and users.name like '%$term%'";
        } else {
            $termCnd = '';
        }

        $messageSetting = MessageSetting::first();

        if (auth()->user()->hasRole('admin')) {
            if ($messageSetting->allow_client_admin == 'no') {
                $termCnd .= "and roles.name != 'client'";
            }
        } elseif (auth()->user()->hasRole('employee')) {
            if ($messageSetting->allow_client_employee == 'no') {
                $termCnd .= "and roles.name != 'client'";
            }
        } elseif (auth()->user()->hasRole('client')) {
            if ($messageSetting->allow_client_admin == 'no') {
                $termCnd .= "and roles.name != 'admin'";
            }
            if ($messageSetting->allow_client_employee == 'no') {
                $termCnd .= "and roles.name != 'employee'";
            }
        }

        $query = DB::select("SELECT * FROM ( SELECT * FROM (
                    SELECT users.id,'0' AS groupId, users.name,  users.image,  users_chat.created_at as last_message, users_chat.message, users_chat.message_seen, users_chat.user_one
                    FROM users
                    INNER JOIN users_chat ON users_chat.from = users.id
                    LEFT JOIN role_user ON role_user.user_id = users.id
                    LEFT JOIN roles ON roles.id = role_user.role_id
                    WHERE users_chat.to = $userID $termCnd
                    UNION
                    SELECT users.id,'0' AS groupId, users.name,users.image, users_chat.created_at  as last_message, users_chat.message, users_chat.message_seen, users_chat.user_one
                    FROM users
                    INNER JOIN users_chat ON users_chat.to = users.id
                    LEFT JOIN role_user ON role_user.user_id = users.id
                    LEFT JOIN roles ON roles.id = role_user.role_id
                    WHERE users_chat.from = $userID  $termCnd
                    ) AS allUsers
                    ORDER BY  last_message DESC
                    ) AS allUsersSorted
                    GROUP BY id
                    ORDER BY  last_message DESC");

        return $query;
    }

    public static function isAdmin($userId)
    {
        $user = User::find($userId);
        return $user->hasRole('admin') ? true : false;
    }

    public static function isClient($userId)
    {
        $user = User::find($userId);
        return $user->hasRole('client') ? true : false;
    }

    public static function isEmployee($userId)
    {
        $user = User::find($userId);
        return $user->hasRole('employee') ? true : false;
    }

    public function getModulesAttribute()
    {

        $user = auth()->user();

        $module = new ModuleSetting();

        if ($user->hasRole('admin')) {
            $module = $module->where('type', 'admin');

        } elseif ($user->hasRole('client')) {
            $module = $module->where('type', 'client');

        } elseif ($user->hasRole('employee')) {
            $module = $module->where('type', 'employee');
        }

        $module = $module->where('status', 'active');
        $module->select('module_name');

        $module = $module->get();
        $moduleArray = [];
        foreach ($module->toArray() as $item) {
            array_push($moduleArray, array_values($item)[0]);
        }

        return $moduleArray;
    }

    public function getNameAttribute($value)
    {
        if ($this->isClient($this->id)) {
            $client = ClientDetails::select('id', 'company_id', 'name')
                ->where(
                    'user_id', $this->id
                )
                ->first();

            return $client['name'];
        }

        return $value;
    }

    public function getEmailAttribute($value)
    {
        if ($this->isClient($this->id)) {
            $client = ClientDetails::select('id', 'company_id', 'email')
                ->where(
                    'user_id', $this->id
                )
                ->first();

            return $client['email'];
        }

        return $value;
    }

    public function getImageAttribute($value)
    {
        if (!is_null($this->id) && $this->isClient($this->id)) {
            $client = ClientDetails::select('id', 'company_id', 'image')
                ->where(
                    'user_id', $this->id
                )
                ->first();

            return $client['image'];
        }

        return $value;
    }

    public function getMobileAttribute($value)
    {
        if ($this->isClient($this->id)) {
            $client = ClientDetails::select('id', 'company_id', 'mobile')
                ->where(
                    'user_id', $this->id
                )
                ->first();

            return $client['mobile'];
        }

        return $value;
    }
}

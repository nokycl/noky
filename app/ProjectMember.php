<?php

namespace App;

use App\Observers\ProjectMemberObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProjectMember extends Model
{
    use Notifiable;

    protected static function boot()
    {
        parent::boot();

        static::observe(ProjectMemberObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('project_members.company_id', '=', $company->id);
            }
        });
    }

    public function routeNotificationForMail()
    {
        return $this->user->email;
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active']);
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public static function byProject($id){
        return ProjectMember::join('users', 'users.id', '=', 'project_members.user_id')
            ->where('project_members.project_id', $id)
            ->where('users.status','active')
            ->get();
    }

    public static function checkIsMember($projectId, $userId){
        return ProjectMember::where('project_id', $projectId)
            ->where('user_id', $userId)->first();
    }
}

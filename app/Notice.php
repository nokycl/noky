<?php

namespace App;

use App\Observers\NoticeObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notice extends Model
{
    use Notifiable;
    protected $appends = ['notice_date'];

    protected static function boot()
    {
        parent::boot();

        static::observe(NoticeObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('notices.company_id', '=', $company->id);
            }
        });
    }

    public function getNoticeDateAttribute(){
        if(!is_null($this->created_at)){
            return Carbon::parse($this->created_at)->format('d F, Y');
        }
        return "";
    }
}

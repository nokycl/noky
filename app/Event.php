<?php

namespace App;

use App\Observers\EventObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $dates = ['start_date_time', 'end_date_time'];

    protected static function boot()
    {
        parent::boot();

        static::observe(EventObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('events.company_id', '=', $company->id);
            }
        });
    }

    public function attendee(){
        return $this->hasMany(EventAttendee::class, 'event_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Observers\ClientContactObserver;

class ClientContact extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(ClientContactObserver::class);

        $company = company();
        
        static::addGlobalScope('company', function (Builder $builder) use ($company) {
            if ($company) {
                $builder->where('client_contacts.company_id', '=', $company->id);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

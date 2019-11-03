<?php
namespace App;

use App\Observers\LogTimeForObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Holiday
 * @package App\Models
 */
class LogTimeFor extends Model
{
    // Don't forget to fill this array
    protected $fillable = [];

    protected $guarded = ['id'];
    protected $table = 'log_time_for';

    protected static function boot()
    {
        parent::boot();

        static::observe(LogTimeForObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('log_time_for.company_id', '=', $company->id);
            }
        });
    }

}
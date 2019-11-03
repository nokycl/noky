<?php
namespace App;

use App\Observers\LeadFileObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * Class Holiday
 * @package App\Models
 */
class LeadFiles extends Model
{
    // Don't forget to fill this array
    protected $fillable = [];

    protected $guarded = ['id'];
    protected $table =  'lead_files';

    protected static function boot()
    {
        parent::boot();

        static::observe(LeadFileObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('lead_files.company_id', '=', $company->id);
            }
        });
    }

    public function lead(){
        return $this->belongsTo(Lead::class);
    }
}
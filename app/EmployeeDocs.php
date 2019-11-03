<?php
namespace App;

use App\Observers\EmployeeDocsObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Holiday
 * @package App\Models
 */
class EmployeeDocs extends Model
{
    // Don't forget to fill this array
    protected $fillable = [];

    protected $guarded = ['id'];
    protected $table =  'employee_docs';

    protected static function boot()
    {
        parent::boot();

        static::observe(EmployeeDocsObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('employee_docs.company_id', '=', $company->id);
            }
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
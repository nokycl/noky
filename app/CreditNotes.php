<?php

namespace App;

use App\Observers\CreditNoteObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CreditNotes extends Model
{
    use Notifiable;

    protected $dates = ['issue_date', 'due_date'];
    protected $appends = ['total_amount', 'issue_on', 'cn_number', 'original_cn_number'];

    protected static function boot()
    {
        parent::boot();

        static::observe(CreditNoteObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('credit_notes.company_id', '=', $company->id);
            }
        });
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id','id');
    }

    public function items(){
        return $this->hasMany(CreditNoteItem::class, 'credit_note_id');
    }

    public function payment(){
        return $this->hasMany(Payment::class, 'invoice_id', 'invoice_id')->orderBy('paid_on', 'desc');
    }

    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public static function clientInvoices($clientId) {
        return CreditNotes::join('projects', 'projects.id', '=', 'credit_notes.project_id')
            ->select('projects.project_name', 'credit_notes.*')
            ->where('projects.client_id', $clientId)
            ->get();
    }

    public function getPaidAmount(){
        return Payment::where('invoice_id', $this->invoice_id)->sum('amount');
    }

    public function getTotalAmountAttribute(){

        if(!is_null($this->total) && !is_null($this->currency_symbol)){
            return $this->currency_symbol . $this->total;
        }

        return "";
    }

    public function getIssueOnAttribute(){
        if(!is_null($this->issue_date)){
            return Carbon::parse($this->issue_date)->format('d F, Y');
        }
        return "";
    }

    public function getOriginalCnNumberAttribute(){
        $invoiceSettings = InvoiceSetting::select('invoice_digit')->first();
        $zero = '';
        if (strlen($this->attributes['cn_number']) < $invoiceSettings->invoice_digit){
            for ($i=0; $i<$invoiceSettings->invoice_digit-strlen($this->attributes['cn_number']); $i++){
                $zero = '0'.$zero;
            }
        }
        $zero = '#'.$zero.$this->attributes['cn_number'];
        return $zero;
    }

    public function getCnNumberAttribute($value){
        if(!is_null($value)){
            $invoiceSettings = InvoiceSetting::select('credit_note_prefix', 'credit_note_digit')->first();
            $zero = '';
            if (strlen($value) < $invoiceSettings->credit_note_digit){
                for ($i=0; $i<$invoiceSettings->credit_note_digit-strlen($value); $i++){
                    $zero = '0'.$zero;
                }
            }
            $zero = $invoiceSettings->credit_note_prefix.'#'.$zero.$value;
            return $zero;
        }
        return "";
    }
}

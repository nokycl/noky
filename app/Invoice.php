<?php

namespace App;

use App\Observers\InvoiceObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invoice extends Model
{
    use Notifiable;

    protected $dates = ['issue_date', 'due_date'];
    protected $appends = ['total_amount', 'issue_on', 'invoice_number', 'original_invoice_number'];

    protected static function boot()
    {
        parent::boot();

        static::observe(InvoiceObserver::class);

        $company = company();

        static::addGlobalScope('company', function (Builder $builder) use($company) {
            if ($company) {
                $builder->where('invoices.company_id', '=', $company->id);
            }
        });
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function items(){
        return $this->hasMany(InvoiceItems::class, 'invoice_id');
    }

    public function payment(){
        return $this->hasMany(Payment::class, 'invoice_id')->orderBy('paid_on', 'desc');
    }

    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public static function clientInvoices($clientId) {
        return Invoice::join('projects', 'projects.id', '=', 'invoices.project_id')
            ->select('projects.project_name', 'invoices.*')
            ->where('projects.client_id', $clientId)
            ->get();
    }

    public function getPaidAmount(){
        return Payment::where('invoice_id', $this->id)->sum('amount');
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

    public function getOriginalInvoiceNumberAttribute(){
        $invoiceSettings = InvoiceSetting::select('invoice_digit')->first();
        $zero = '';
        if (strlen($this->attributes['invoice_number']) < $invoiceSettings->invoice_digit){
            for ($i=0; $i<$invoiceSettings->invoice_digit-strlen($this->attributes['invoice_number']); $i++){
                $zero = '0'.$zero;
            }
        }
        $zero = '#'.$zero.$this->attributes['invoice_number'];
        return $zero;
    }

    public function getInvoiceNumberAttribute($value){
        if(!is_null($value)){
            $invoiceSettings = InvoiceSetting::select('invoice_prefix', 'invoice_digit')->first();
            $zero = '';
            if (strlen($value) < $invoiceSettings->invoice_digit){
                for ($i=0; $i<$invoiceSettings->invoice_digit-strlen($value); $i++){
                    $zero = '0'.$zero;
                }
            }
            $zero = $invoiceSettings->invoice_prefix.'#'.$zero.$value;
            return $zero;
        }
        return "";
    }
}
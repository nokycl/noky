<?php

namespace App\Http\Requests;

use App\Estimate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEstimate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $company = company();
        $estimate = Estimate::find($this->route('estimate'));
        return [
            'client_id' => 'required',
            'estimate_number' => Rule::unique('estimates')->where(function ($query) {
                return $query->where('company_id', company()->id);
            }),
            'valid_till' => 'required',
            'sub_total' => 'required',
            'total' => 'required',
            'currency_id' => 'required'
        ];
    }
}

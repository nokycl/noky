<?php

namespace App\Http\Requests\Expenses;

use Froiden\LaravelInstaller\Request\CoreRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreExpense extends CoreRequest
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
        return [
            'item_name' => 'required',
            'purchase_date' => 'required',
            'price' => 'required|numeric'
        ];
    }
}

<?php

namespace App\Http\Requests\SuperAdmin\Companies;

use App\Http\Requests\SuperAdmin\SuperAdminBaseRequest;

class UpdateRequest extends SuperAdminBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => 'required|unique:companies,company_name,'.$this->route('company'),
            'company_email' => 'required|email|unique:companies,company_email,'.$this->route('company'),
            'company_phone' => 'required',
            'address' => 'required',
            'status' => 'required'
        ];
    }
}

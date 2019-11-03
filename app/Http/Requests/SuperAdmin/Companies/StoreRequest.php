<?php

namespace App\Http\Requests\SuperAdmin\Companies;

use App\Http\Requests\SuperAdmin\SuperAdminBaseRequest;

class StoreRequest extends SuperAdminBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "company_name" => "required|unique:companies",
            "company_email" => "required|email|unique:companies",
            "company_phone" => "required",
            "address" => "required",
            "status" => "required",
            'email' => 'required|unique:users',
            'password' => 'required|min:6'
        ];
    }
}

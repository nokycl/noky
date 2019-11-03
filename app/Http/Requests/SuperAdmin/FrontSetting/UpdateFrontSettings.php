<?php

namespace App\Http\Requests\SuperAdmin\FrontSetting;

use App\Http\Requests\SuperAdmin\SuperAdminBaseRequest;

class UpdateFrontSettings extends SuperAdminBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "header_title" => "required",
            "header_description" => "required",
            "feature_title" => "required",
            "price_title" => "required",
            "price_description" => "required",
            "address" => "required",
            "phone" => "required",
            "email" => "required | email",
        ];
    }
}

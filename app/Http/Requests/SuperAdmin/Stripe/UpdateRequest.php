<?php

namespace App\Http\Requests\SuperAdmin\Stripe;

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
        $rules = [];

        // Validation request for stripe keys for stripe if stripe status in active
        if($this->has('stripe_status')){
            $rules["api_key"] = "required";
            $rules["api_secret"] = "required";
            $rules["webhook_key"] = "required";
        }

        // Validation request for paypal keys for paypal if paypal status in active
        if($this->has('paypal_status')){
            $rules["paypal_client_id"] = "required";
            $rules["paypal_secret"] = "required";
        }

        return $rules;
    }
}

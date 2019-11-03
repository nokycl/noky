<?php

namespace App\Http\Requests\Admin\Client;

use App\Http\Requests\CoreRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends CoreRequest
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
        $rules = [
            "name" => "required",
            "email" => "required|email",
            'slack_username' => 'nullable|unique:employee_details,slack_username',
            'website' => 'nullable|url',
//            'facebook' => 'nullable|regex:/http(s)?:\/\/(www\.)?(facebook|fb)\.com\/(A-z 0-9)?/',
//            'twitter' => 'nullable|regex:/http(s)?://(.*\.)?twitter\.com\/[A-z 0-9 _]+\/?/',
//            'linkedin' => 'nullable|regex:/((http(s?)://)*([www])*\.|[linkedin])[linkedin/~\-]+\.[a-zA-Z0-9/~\-_,&=\?\.;]+[^\.,\s<]/',

        ];

        return $rules;
    }
}

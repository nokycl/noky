<?php

namespace App\Http\Requests\TimeLogs;

use App\Http\Requests\CoreRequest;
use App\LogTimeFor;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimeLog extends CoreRequest
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
        $rules =  [
            'start_time' => 'required',
            'end_time' => 'required',
            'memo' => 'required',
        ];
        $logTimeFor = LogTimeFor::first();
        if($logTimeFor->log_time_for == 'project'){
            $rules['user_id'] = 'required';
        }
        else{
            $rules['task_id'] = 'required';
        }
      return $rules;
    }

    public function messages() {
        return [
            'project_id.required' => __('messages.chooseProject')
        ];
    }
}

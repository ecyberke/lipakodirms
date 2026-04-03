<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestsRequest extends FormRequest
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
           
            'full_name'=>'required',            
            'house_no'=>'required',
            'service_request'=>'required',
            'requested_date'=>'required',
           // 'emergency_number'=>'required',
           // 'phone_no'=>'required',
            // 'password'=>'required',
            
        ];
    }
}

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
            //'id' => 'required',
            'apartment_id' => 'required',
            // 'house_id' => 'required',
            // 'tenant_id' => 'required',
            'service_request' => 'required',
            // 'requested_date' => 'required',           
        ];

    }
}

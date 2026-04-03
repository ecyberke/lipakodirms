<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateHouseTenantRequest extends FormRequest
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
            'house_id' => 'required|unique:house_tenants,house_id',
            'apartment' => 'required',
            'tenant_id' => 'required',
            'deposit_amount' => 'required|numeric',
            // 'rent_amount' => 'required|numeric', 
        //   'placement_date' => 'required|date_format:YYYY-MM-DD', 

        ];
    }
}

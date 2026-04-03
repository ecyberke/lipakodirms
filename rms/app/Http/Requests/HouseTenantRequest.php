<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HouseTenantRequest extends FormRequest
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
            // 'id'=>'required|unique:tenants,id',
            'full_name'=>'required',            
            'house_no'=>'required',
            'apartment_name'=>'required',
            // 'rent'=>'required',
            
        ];
    }
}

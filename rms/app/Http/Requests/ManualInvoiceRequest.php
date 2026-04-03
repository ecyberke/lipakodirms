<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManualInvoiceRequest extends FormRequest
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
            // 'id' => 'required',
            // 'type' => 'required',
            // 'bill_amount' => 'required',
            // 'bill_description' => 'required',  
            
            'type' => 'required',
            'tenant_name' => 'required',
            'apartment_name' => 'required',
            'house_name' => 'required',
            'total_payable' => 'required',
            'description' => 'required',
        ];
        
       

    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMonthlyBillingRequest extends FormRequest
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
            'house_id'=>'required',
            'billing_amount.*'=>'nullable|required|numeric',
            'billing_name.*'=>'nullable|required',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'house_id.required'=>'Select An apartment and corresponding house to proceed',
            'billing_amount.*.numeric'=>'Each Bill has to be in correct format',
            'billing_amount.*.required'=>'All the defined Bills amount are required',
            'billing_name.*.required'=>'Defined row for Bill Name is required',
        ];
    }
}

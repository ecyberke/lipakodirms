<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayOwnersRequest extends FormRequest
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
            'paid_in' => 'required|numeric',
            'transaction_code' => 'required',
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
            'paid_in.required' => 'Paid In Amount is required. If overpayment is greater
            than current pay for the property owner ,put zero in the amount paid.',
            'paid_in.numeric' => 'Amount should only be in numbers.Ensure you put
            correct format without commas or other characters',
        ];
    }
}

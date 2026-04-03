<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositRefundRequest extends FormRequest
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
            // 'deposit_invoice_id' => 'required|unique:repairs,deposit_invoice_id',
            // 'deposit_invoice_id' => 'required|unique:tenant_bills,deposit_invoice_id',
            // 'deposit_invoice_id' => 'required|unique:owner_invoices,deposit_invoice_id',
            // 'apartment' => 'required',
            // 'tenant_id' => 'required',
            // 'deposit_amount' => 'required|numeric',
            // 'rent_amount' => 'required|numeric', 
        //   'placement_date' => 'required|date_format:YYYY-MM-DD', 

        ];
    }
}

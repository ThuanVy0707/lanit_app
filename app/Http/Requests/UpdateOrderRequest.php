<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_number' => ['required', 'string', Rule::unique('orders')->ignore($this->order)],
            'client_id' => ['required', 'exists:clients,id'],
            'invoice_id' => ['nullable', 'exists:invoices,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'payment_status' => ['required', 'string', 'in:Pending,Paid,Cancelled,Refunded'],
            'status' => ['required', 'string', 'in:Pending,Active,Cancelled,Fraud,Completed'],
            'fraud_module' => ['nullable', 'string', 'max:255'],
            'fraud_output' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'ip_address' => ['nullable', 'ip'],
            'promo_code' => ['nullable', 'string', 'max:255'],
            'promo_type' => ['nullable', 'string', 'max:255'],
            'promo_value' => ['nullable', 'string', 'max:255'],
            'line_items' => ['nullable', 'array'],
            'line_items.*.type' => ['required_with:line_items', 'string'],
            'line_items.*.product' => ['nullable', 'string'],
            'line_items.*.domain' => ['nullable', 'string'],
            'line_items.*.billing_cycle' => ['nullable', 'string'],
            'line_items.*.amount' => ['required_with:line_items', 'numeric', 'min:0'],
            'line_items.*.status' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'Please select a client.',
            'client_id.exists' => 'The selected client does not exist.',
            'order_number.required' => 'Order number is required.',
            'order_number.unique' => 'This order number already exists.',
            'amount.required' => 'Order amount is required.',
            'payment_status.required' => 'Payment status is required.',
            'status.required' => 'Order status is required.',
        ];
    }
}

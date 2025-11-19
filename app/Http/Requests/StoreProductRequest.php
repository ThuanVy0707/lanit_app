<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:hostingaccount,domain,addon,other'],
            'status' => ['required', 'string', 'in:Pending,Active,Suspended,Terminated,Cancelled'],
            'amount' => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'string', 'in:monthly,quarterly,semiannually,annually,biennially,triennially,onetime'],
            'next_due_date' => ['nullable', 'date', 'after_or_equal:today'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'client_id.required' => 'Client is required.',
            'client_id.exists' => 'Selected client does not exist.',
            'name.required' => 'Product name is required.',
            'type.required' => 'Product type is required.',
            'type.in' => 'Invalid product type selected.',
            'status.required' => 'Product status is required.',
            'status.in' => 'Invalid product status selected.',
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a valid number.',
            'billing_cycle.required' => 'Billing cycle is required.',
            'billing_cycle.in' => 'Invalid billing cycle selected.',
            'next_due_date.after_or_equal' => 'Next due date must be today or a future date.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
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
            'invoice_number' => ['required', 'string', 'max:255', Rule::unique('invoices', 'invoice_number')->ignore($this->invoice)],
            'date' => ['required', 'date'],
            'duedate' => ['required', 'date', 'after_or_equal:date'],
            'subtotal' => ['required', 'numeric', 'min:0'],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'total' => ['required', 'numeric', 'min:0'],
            'credit' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:Draft,Unpaid,Paid,Cancelled,Refunded'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
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
            'invoice_number.required' => 'Invoice number is required.',
            'invoice_number.unique' => 'Invoice number already exists.',
            'date.required' => 'Invoice date is required.',
            'duedate.required' => 'Due date is required.',
            'duedate.after_or_equal' => 'Due date must be equal to or after invoice date.',
            'subtotal.required' => 'Subtotal is required.',
            'total.required' => 'Total amount is required.',
            'status.required' => 'Invoice status is required.',
            'status.in' => 'Invalid invoice status selected.',
        ];
    }
}

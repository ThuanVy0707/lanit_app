<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
            'ticket_number' => ['required', 'string', 'unique:tickets,ticket_number'],
            'subject' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'in:Support,Sales,Billing,Technical'],
            'priority' => ['required', 'string', 'in:Low,Medium,High,Urgent'],
            'status' => ['required', 'string', 'in:Open,In Progress,On Hold,Closed'],
            'message' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'Please select a client.',
            'client_id.exists' => 'The selected client does not exist.',
            'ticket_number.required' => 'Ticket number is required.',
            'ticket_number.unique' => 'This ticket number already exists.',
            'subject.required' => 'Subject is required.',
            'department.required' => 'Please select a department.',
            'department.in' => 'Invalid department selected.',
            'priority.required' => 'Please select a priority.',
            'priority.in' => 'Invalid priority selected.',
            'status.required' => 'Please select a status.',
            'status.in' => 'Invalid status selected.',
            'message.required' => 'Message is required.',
        ];
    }
}

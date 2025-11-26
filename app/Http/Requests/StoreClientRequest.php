<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'owner_user_id' => ['nullable', 'exists:users,id'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'companyname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:clients,email'],
            'address1' => ['nullable', 'string', 'max:255'],
            'address2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:20'],
            'countrycode' => ['nullable', 'string', 'size:2'],
            'phonenumber' => ['nullable', 'string', 'max:20'],
            'tax_id' => ['nullable', 'string', 'max:50'],
            'email_preferences' => ['nullable', 'array'],
            'currency_id' => ['nullable', 'integer'],
            'defaultgateway' => ['nullable', 'string', 'max:255'],
            'groupid' => ['nullable', 'integer'],
            'status' => ['nullable', 'string', 'in:Active,Inactive,Closed'],
            'credit' => ['nullable', 'numeric', 'min:0'],
            'taxexempt' => ['nullable', 'boolean'],
            'latefeeoveride' => ['nullable', 'boolean'],
            'overideduenotices' => ['nullable', 'boolean'],
            'separateinvoices' => ['nullable', 'boolean'],
            'disableautocc' => ['nullable', 'boolean'],
            'emailoptout' => ['nullable', 'boolean'],
            'marketing_emails_opt_in' => ['nullable', 'boolean'],
            'overrideautoclose' => ['nullable', 'boolean'],
            'allowSingleSignOn' => ['nullable', 'boolean'],
            'email_verified' => ['nullable', 'boolean'],
            'language' => ['nullable', 'string', 'max:10'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'firstname.required' => 'First name is required.',
            'lastname.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered.',
        ];
    }
}

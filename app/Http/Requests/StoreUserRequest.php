<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('messages.msg_name_required'),
            'email.required' => __('messages.msg_email_required'),
            'email.email' => __('messages.msg_email_invalid'),
            'email.unique' => __('messages.msg_email_unique'),
            'password.required' => __('messages.msg_password_required'),
            'password.min' => __('messages.msg_password_min'),
            'password.confirmed' => __('messages.msg_password_confirmed'),
        ];
    }
}

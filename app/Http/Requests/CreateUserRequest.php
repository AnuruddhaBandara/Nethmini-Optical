<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'first_name' => ['required'],
            'password' => ['required',  Password::defaults(), 'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*])/', 'min:8', 'confirmed'],
            'role_id' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First Name is required.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter and one symbol.',
            'role_id.required' => 'Select a role is required.',
        ];
    }
}

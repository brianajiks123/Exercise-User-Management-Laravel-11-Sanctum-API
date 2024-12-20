<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name" => "required|string|max:200",
            "email" => "required|email|unique:users,email",
            "phone_number" => "required|digits:13",
            "password" => "required|min:8"
        ];
    }

    /**
     * Get the validation error messages that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            "name.required" => "Please enter your full name",
            "name.string" => "Full name must be string",
            "name.max" => "Full name must not be more than 200 characters",
            "email.required" => "Please enter your email",
            "email.email" => "Email must be a valid email",
            "email.unique" => "Email is already registered. Please use other email",
            "phone_number.required" => "Please enter your phone number",
            "phone_number.digits" => "Phone number must be 13 digits number",
            "password.required" => "Please enter your password",
            "password.min" => "Password must be atleast 8 characters long"
        ];
    }
}

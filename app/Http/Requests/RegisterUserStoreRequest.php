<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserStoreRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'nid' => ['required', 'numeric', 'digits_between:10,17', 'unique:users,nid'],
            'vaccine_center_id' => ['required', 'exists:vaccine_centers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Enter your full name',
            'email.required' => 'Enter your email address',
            'nid.required' => 'Enter your 10 to 17 digit National ID',
            'vaccine_center_id.required' => 'Select a vaccination center',
        ];
    }
}

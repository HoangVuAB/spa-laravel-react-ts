<?php

namespace App\Http\Requests\Auth;

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
        $regexKana = config('regex.kana');
        $regexEmail = config('regex.email');
        $regexPassword = config('regex.password');
        $regexPhoneNumber = config('regex.phone_number');

        return [
            'user_name' => ['required', 'string', 'max:255'],
            'user_name_kana' => ['nullable', 'string', 'max:255', 'regex:'.$regexKana],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', 'regex:'.$regexEmail],
            'postcode' => ['nullable', 'numeric', 'digits:7'],
            'address' => ['nullable', 'string', 'max:255'],
            'address_detail' => ['nullable', 'string', 'max:255'],
            'google_id' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255', 'regex:'.$regexPhoneNumber],
            'password' => ['required', 'confirmed', 'min:8', 'max:64', 'regex:'.$regexPassword],
        ];
    }
}

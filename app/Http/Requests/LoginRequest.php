<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'login' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $loginType = $this->getLoginType($value);
                    
                    switch ($loginType) {
                        case 'email':
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $fail('Format email tidak valid.');
                            }
                            break;
                            
                        case 'username':
                            if (!preg_match('/^[a-zA-Z0-9_]{5,30}$/', $value)) {
                                $fail('Username harus 5-30 karakter dan hanya boleh mengandung huruf, angka, dan underscore.');
                            }
                            break;
                            
                        case 'whatsapp':
                            $phone = preg_replace('/[^0-9]/', '', $value);
                            if (!preg_match('/^(08|628)[0-9]{8,11}$/', $phone)) {
                                $fail('Format nomor WhatsApp tidak valid. Gunakan format: 08xxxxxxxxxx atau 628xxxxxxxxxx.');
                            }
                            break;
                    }
                }
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                // Uncomment untuk password complexity
                // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'remember' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'login.required' => 'Email, username, atau nomor WhatsApp wajib diisi.',
            'login.string' => 'Email, username, atau nomor WhatsApp harus berupa teks.',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal :min karakter.',
            'password.regex' => 'Password harus mengandung minimal satu huruf kecil, satu huruf besar, dan satu angka.',
            'remember.boolean' => 'Pilihan ingat saya tidak valid.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'login' => 'Email/Username/WhatsApp',
            'password' => 'Password',
            'remember' => 'Ingat Saya',
        ];
    }

    /**
     * Determine the login type based on input value.
     *
     * @param string $value
     * @return string
     */
    protected function getLoginType($value): string
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }
        
        if (preg_match('/^(\+62|62|0)[0-9]+$/', $value)) {
            return 'whatsapp';
        }
        
        return 'username';
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->expectsJson()) {
            $errors = $validator->errors();
            
            throw new \Illuminate\Validation\ValidationException($validator, response()->json([
                'success' => false,
                'message' => 'Data yang Anda masukkan tidak valid.',
                'errors' => $errors->toArray(),
            ], 422));
        }
        
        parent::failedValidation($validator);
    }
}

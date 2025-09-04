<?php

namespace App\Http\Api\V1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // TODO: o integra Gates/Policies
    }

    public function rules(): array
    {
        return [
            "email" => ["required", "email", "max:100"],
            "password" => ["required", "string", "max:15"]
        ];
    }

    public function messages(): array
    {
        return [
            // 'field.rule' => 'custom message',
        ];
    }
}

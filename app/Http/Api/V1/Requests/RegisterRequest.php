<?php

namespace App\Http\Api\V1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // TODO: o integra Gates/Policies
    }

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:100"],
            "surname" => ["required", "string", "max:100"],
            "email" => ["required", "email", "max:100", "unique:users,email"],
            "password" => ["required", "string", "max:15", "confirmed"]
        ];
    }
}

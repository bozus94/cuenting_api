<?php

namespace App\Http\Api\V1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // TODO: o integra Gates/Policies
    }

    public function rules(): array
    {
        return [
            '// TODO: define reglas'
        ];
    }

    public function messages(): array
    {
        return [
            // 'field.rule' => 'custom message',
        ];
    }
}

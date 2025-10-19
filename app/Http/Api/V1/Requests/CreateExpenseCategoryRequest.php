<?php

namespace App\Http\Api\V1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateExpenseCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // TODO: o integra Gates/Policies
    }

    public function rules(): array
    {
        return [
            "name" => ["required", "max:100", "unique:expense_categories,name"]
        ];
    }
}

<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\ExpenseCategory;
use App\Repositories\Contracts\ExpenseCategoryRepositoryInterface;

class EloquentExpenseCategoryRepository implements ExpenseCategoryRepositoryInterface
{
    public function create(array $data): ExpenseCategory
    {
        return ExpenseCategory::create($data);
    }

    public function findByName(string $name): ?ExpenseCategory
    {
        return ExpenseCategory::where("name", "=", $name)->first();
    }
}

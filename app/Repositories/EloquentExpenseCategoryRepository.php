<?php

namespace App\Repositories;

use App\DTOs\expense\QueryCategoryDTO;
use App\Models\ExpenseCategory;
use App\Repositories\Contracts\ExpenseCategoryRepositoryInterface;

class EloquentExpenseCategoryRepository implements ExpenseCategoryRepositoryInterface
{
    public function queryForUser(QueryCategoryDTO $dto, int $userId)
    {
        $query = ExpenseCategory::query()
            ->where('user_id', $userId);

        if (!is_null($dto->active)) {
            $query->where('is_active', $dto->active);
        }
    }

    public function create(array $data): ExpenseCategory
    {
        return ExpenseCategory::create($data);
    }

    public function findByName(string $name): ?ExpenseCategory
    {
        return ExpenseCategory::where("name", "=", $name)->first();
    }
}

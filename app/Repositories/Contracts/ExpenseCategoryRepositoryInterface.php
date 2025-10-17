<?php

namespace App\Repositories\Contracts;

use App\Models\ExpenseCategory;

interface ExpenseCategoryRepositoryInterface
{
    public function create(array $data): ExpenseCategory;
    public function findByName(string $name): ?ExpenseCategory;
    /* public function delete(string $id): bool; */
}

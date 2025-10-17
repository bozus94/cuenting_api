<?php

namespace App\Services\Contracts;

use App\DTOs\Category\CreateCategoryDTO;
use App\DTOs\Category\ResponseCategoryDTO;

interface ExpenseCategoryServiceInterface
{
    public function createCategory(CreateCategoryDTO $data): ResponseCategoryDTO;
}

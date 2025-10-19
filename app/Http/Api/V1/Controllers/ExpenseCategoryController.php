<?php

namespace App\Http\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DTOs\Category\CreateCategoryDTO;
use App\Http\Api\V1\Requests\CreateExpenseCategoryRequest;
use App\Services\Contracts\ExpenseCategoryServiceInterface;
use App\Traits\CuentingResponse;

class ExpenseCategoryController extends Controller
{
    use CuentingResponse;

    public function __construct(public readonly ExpenseCategoryServiceInterface $service) {}

    /* public function ListByUser(QueryCategoryRequest $request)
    {
        $categories = $this->service->ListCategoriesByUser(QueryCategoryDto::fromArray($request->validated()));
        return $this->success("LIST_CATEGORIES_OK", "Categories list by user", $categories->toArray(), 401);
    } */

    public function store(CreateExpenseCategoryRequest $request)
    {
        $category = $this->service->createCategory(CreateCategoryDTO::fromArray($request->validated()));
        return $this->success('CATEGORY_CREATED_OK', 'Category created successfully', $category->toArray(), 401);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}

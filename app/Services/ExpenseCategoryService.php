<?php

namespace App\Services;

use Throwable;
use App\Enums\DomainErrors;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\DB;
use App\DTOs\Category\CreateCategoryDTO;
use App\DTOs\Category\ResponseCategoryDTO;
use App\Exceptions\Cuenting\DomainException;
use App\Services\Contracts\ExpenseCategoryServiceInterface;
use App\Repositories\Contracts\ExpenseCategoryRepositoryInterface;


class ExpenseCategoryService implements ExpenseCategoryServiceInterface
{

    public function __construct(public ExpenseCategoryRepositoryInterface $repo) {}

    public function createCategory(CreateCategoryDTO $dto): ResponseCategoryDTO
    {
        try {
            return DB::transaction(function () use ($dto) {
                /* Los nombres de categorías deben ser únicos por usuario */
                $category = $this->repo->findByName($dto->name);
                if ($category && $category->id == auth()->guard()->user()->id) {
                    throw new DomainException(DomainErrors::ENTITY_ALREADY_EXIST->name);
                }

                /* se establece el id del usuario */
                $dto->setUserId(auth()->guard('api')->user()->id);
                $newCategory = $this->repo->create($dto->toArray());
                return ResponseCategoryDTO::fromModel($newCategory);
            });
        } catch (Throwable $th) {
            throw new DomainException(DomainErrors::REGISTER_PROCESSING_OPERATION->name, 422, $th->getTrace());
        }
    }
}

<?php

namespace App\DTOs\Category;

use App\DTOs\Contracts\ResponseDtoInterface;
use Illuminate\Database\Eloquent\Model;

/**
 *DTO for responses related with categories.
 */

final class ResponseCategoryDTO implements ResponseDtoInterface
{

  public function __construct(
    public readonly string $name,
    public readonly int $userId,
    public readonly bool $isActive,
    public readonly bool $isDefault,
    public readonly string $deleteAt,
    public readonly string $updatedAt,
  ) {}

  public static function fromModel(Model $model): ResponseDtoInterface
  {
    return new self(
      name: $model->name,
      userId: $model->user_id,
      isActive: $model->is_active,
      isDefault: $model->is_default,
      updatedAt: $model->updated_at,
      deleteAt: $model->delete_at
    );
  }

  public function toArray(): array
  {
    return [
      "name" => $this->name,
      "user_id" => $this->userId,
      "is_active" => $this->isActive,
      "is_default" => $this->isDefault,
      "updated_at" => $this->updatedAt,
      "delete_at" => $this->deleteAt
    ];
  }
}

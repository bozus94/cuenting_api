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
    public readonly string $updatedAt,
  ) {}

  public static function fromModel(Model $model): self
  {
    return new self(
      name: $model->name,
      userId: $model->user_id,
      isActive: $model->is_active,
      updatedAt: $model->updated_at,
    );
  }

  public function toArray(): array
  {
    return [
      "name" => $this->name,
      "user_id" => $this->userId,
      "is_active" => (bool) $this->isActive,
      "updated_at" => $this->updatedAt,
    ];
  }
}

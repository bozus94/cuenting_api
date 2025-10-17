<?php

namespace App\DTOs\Category;

use App\DTOs\Contracts\RequestDtoInterface;

/**
 *DTO sin propiedades declaradas.
 */

final class CreateCategoryDTO implements RequestDtoInterface
{
  public function __construct(
    public readonly string $name,
    public readonly string $userId = '',
    public readonly ?bool $isActive = true,
    public readonly ?bool $isDefault = false,
  ) {}

  public static function fromArray(array $data)
  {
    return new self(
      name: $data["name"],
      isActive: $data["is_active"] ?? null,
      isDefault: $data["is_default"] ?? null,
    );
  }

  public function toArray(): array
  {
    return [
      "name" => $this->name,
      "is_active" => $this->isActive,
      "is_default" => $this->isDefault
    ];
  }

  public function setUserId(string $id): void
  {
    $this->userId = $id;
  }
}

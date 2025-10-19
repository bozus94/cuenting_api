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
    public string $userId = '',
    public readonly ?bool $isActive = true,
    public readonly ?bool $isDefault = false,
  ) {}

  public static function fromArray(array $data)
  {
    return new self(
      name: $data["name"],
    );
  }

  public function toArray(): array
  {
    return [
      "name" => $this->name,
      "user_id" => $this->userId,
      "is_active" => $this->isActive
    ];
  }

  public function setUserId(string $id): void
  {
    $this->userId = $id;
  }

  public function setIsActive(): void
  {
    $this->isActive = true;
  }
}

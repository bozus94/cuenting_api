<?php

namespace App\DTOs\Category;

use App\DTOs\Contracts\RequestDtoInterface;

/**
 *DTO sin propiedades declaradas.
 */

final class UpdateCategoryDTO implements RequestDtoInterface
{
  public function __construct(public readonly string $name) {}

  public static function fromArray(array $data): self
  {
    return new self(
      name: $data["name"]
    );
  }

  public function toArray(): array
  {
    return [
      "name" => $this->name
    ];
  }
}

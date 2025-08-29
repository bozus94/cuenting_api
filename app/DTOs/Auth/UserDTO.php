<?php

namespace App\DTOs\Auth;

use Illuminate\Database\Eloquent\Model;

/**
 *DTO sin propiedades declaradas.
 */

final class UserDTO
{
  public function __construct(
    public readonly int $id,
    public readonly string $name,
    public readonly bool $is_active,
    public readonly ?string $last_login_at,
    public readonly string $created_at,
    public readonly string $updated_at,
  ) {}

  public static function fromModel(Model $model)
  {
    return new self(
      id: $model->id,
      name: $model->name,
      is_active: $model->is_active,
      last_login_at: $model->last_login_at,
      created_at: $model->created_at,
      updated_at: $model->created_at,
    );
  }

  public function toArray(): array
  {
    return [
      "id" => $this->id,
      "name" => $this->name,
      "is_active" => $this->is_active,
      "last_login_at" => $this->last_login_at,
      "created_at" => $this->created_at,
      "updated_at" => $this->updated_at
    ];
  }
}

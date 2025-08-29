<?php

namespace App\DTOs\Auth;

/**
 *DTO for login users.
 */

final class RegisterDTO
{
  public function __construct(
    public readonly string $name,
    public readonly string $email,
    public readonly string $password
  ) {}

  public static function toArray(array $data): RegisterDTO
  {
    return new self(
      name: $data["name"],
      email: $data["email"],
      password: $data["password"],
    );
  }
}

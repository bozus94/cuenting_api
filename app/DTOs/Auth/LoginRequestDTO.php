<?php

namespace App\DTOs\Auth;

/**
 *DTO sin propiedades declaradas.
 */

final class LoginRequestDTO
{
  public function __construct(
    public readonly string $email,
    public readonly string $password
  ) {}

  public static function fromArray(array $data): LoginRequestDTO
  {
    return new self(
      email: $data["email"],
      password: $data["password"]
    );
  }

  public function toArray(): array
  {
    return [
      "email" => $this->email,
      "password" => $this->password
    ];
  }
}

<?php

namespace App\DTOs\Auth;

/**
 *DTO for login users.
 */

final class RegisterDTO
{
  public function __construct(
    public readonly string $name,
    public readonly string $surname,
    public readonly string $email,
    public readonly string $password
  ) {}

  public static function fromArray(array $data): RegisterDTO
  {
    return new self(
      name: $data["name"],
      surname: $data["surname"],
      email: $data["email"],
      password: $data["password"],
    );
  }

  public function toArray()
  {
    return [
      "name" => $this->name,
      "surname" => $this->surname,
      "email" => $this->email,
      "password" => $this->password
    ];
  }
}

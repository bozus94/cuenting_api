<?php

namespace App\DTOs\Auth;

/**
 *DTO sin propiedades declaradas.
 */

final class LoginResponseDTO
{
  public function __construct(
    public readonly string $token,
    public readonly string $expires_in,
    public readonly string $token_type = 'Bearer',
  ) {}

  public function toArray(): array
  {
    return [
      "access_token" => $this->token,
      "expires_in" => $this->expires_in,
      "token_type" => $this->token_type,
    ];
  }
}

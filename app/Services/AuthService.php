<?php

namespace App\Services;

use App\DTOs\Auth\AuthTokenDTO;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\LoginRequestDTO;
use App\DTOs\Auth\LoginResponseDTO;
use App\Services\Contracts\AuthServiceInterface;

class AuthService implements AuthServiceInterface
{
    public function __construct() {}

    public function login(LoginRequestDTO $credentials): LoginResponseDTO
    {


        return LoginResponseDTO::fromArray(["token"]);
    }
}

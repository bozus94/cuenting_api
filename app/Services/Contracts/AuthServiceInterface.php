<?php

namespace App\Services\Contracts;

use App\DTOs\Auth\LoginRequestDTO;
use App\DTOs\Auth\LoginResponseDTO;


interface AuthServiceInterface
{
    public function login(LoginRequestDTO $credentials): LoginResponseDTO;
}

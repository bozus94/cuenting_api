<?php

namespace App\Services\Contracts;

use App\DTOs\Auth\LoginRequestDTO;
use App\DTOs\Auth\LoginResponseDTO;
use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Auth\UserDTO;

interface AuthServiceInterface
{
    public function login(LoginRequestDTO $credentials): LoginResponseDTO;
    public function register(RegisterDTO $credentials): UserDTO;
    public function logout();
    public function me(): UserDTO;
}

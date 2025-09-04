<?php

namespace App\Http\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Traits\hasAuthenticate;
use App\Traits\CuentingResponse;
use App\DTOs\Auth\LoginRequestDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Api\V1\Requests\LoginRequest;
use App\Http\Api\V1\Requests\RegisterRequest;
use App\Services\Contracts\AuthServiceInterface;

class AuthController extends Controller
{

    use CuentingResponse;

    public function __construct(private readonly AuthServiceInterface $service) {}

    public function register(RegisterRequest $request)
    {
        $user = $this->service->register(RegisterDTO::fromArray($request->validated()));
        return $this->success("_CREATED_OK", "User registered successful", $user->toArray(), 401);
    }

    public function Login(LoginRequest $request)
    {

        $data = $this->service->login(LoginRequestDTO::fromArray($request->validated()));

        return $this->success("AUTH_LOGIN_OK", "Login success", $data->toArray());
    }

    public function logout()
    {
        return $this->service->logout();
    }

    public function me()
    {
        $user = $this->service->me();
        return $this->success("USER_INFO", "information showing", $user->fullUser());
    }
}

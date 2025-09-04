<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Enums\AuthErrors;
use App\DTOs\Auth\UserDTO;
use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Auth\LoginRequestDTO;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\DTOs\Auth\LoginResponseDTO;
use App\Exceptions\Cuenting\AuthException;
use App\Services\Contracts\AuthServiceInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Traits\CuentingResponse;
use App\Enums\AuthErrors as Error;
use Illuminate\Http\JsonResponse;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;

class AuthService implements AuthServiceInterface
{
    use CuentingResponse;
    public function __construct(public readonly UserRepositoryInterface $repo) {}

    public function register(RegisterDTO $dto): UserDTO
    {
        try {
            return DB::transaction(function () use ($dto) {
                if ($this->repo->FindByEmail($dto->email)) {
                    throw new AuthException(AuthErrors::AUTH_EMAIL_TAKEN->name, 422);
                }
                $user = $this->repo->create($dto->toArray());

                return UserDTO::fromModel($user);
            });
        } catch (Throwable $th) {
            throw new AuthException(Error::REGISTER_PROCESSING_OPERATION->name, 400, $th->getTrace());
        }
    }

    public function login(LoginRequestDTO $credentials): LoginResponseDTO
    {
        try {
            return DB::transaction(function () use ($credentials) {
                if (!$token = JWTAuth::attempt($credentials->toArray())) {
                }

                $this->repo->updateLoginAt(auth()->guard("api")->user());

                return new LoginResponseDTO(
                    $token,
                    config("jwt.ttl") * 60,
                );
            });
        } catch (Throwable $e) {
            throw new AuthException(Error::AUTH_INVALID_CREDENTIALS->name, 400, $e->getTrace());
        }
    }

    public function logout(): JsonResponse
    {
        try {
            JWTAuth::parseToken()->invalidate();
            return $this->success("AUTH_LOGOUT_SUCCESS", "User Disconnect");
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $th) {
            throw new AuthException("AUTH_LOGOUT_ERROR");
        }
    }

    public function me(): UserDTO
    {
        try {
            $user = auth()->guard("api")->user();
            return UserDTO::fromModel($user);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $th) {
            throw new AuthException("USER_INFO_ERROR");
        }
    }
}

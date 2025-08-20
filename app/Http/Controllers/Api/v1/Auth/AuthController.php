<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\hasAuthenticate;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    use hasAuthenticate;

    public function login(Request $request)
    {
        $credentials = $request->only(["email", "password"]);

        $this->loginValidate($credentials);

        return $this->authenticate($credentials);
    }

    public function register(Request $request)
    {
        $this->registerValidate($request->all());

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        return response()->json(["status" => "success", "user" => $user]);
    }

    public function logout(Request $request)
    {
        $this->tokenValidate($request->all());
        return $this->disconnect();
    }

    public function me()
    {
        return response()->json([
            "status" => "success",
            "user" => auth()->user()
        ]);
    }

    /*     protected function loginValidate($data)
    {
        Validator::make($data, [
            "email" => "required|email",
            "password" => "required|min:8"
        ])->validate();
    }

    protected function registerValidate(array $data)
    {
        Validator::make($data, [
            "name" => "required|string",
            "email" => "required|email|unique:users",
            "password" => "required|min:8"
        ])->validate();
    }

    protected function tokenValidate($data)
    {
        Validator::make($data, [
            "token" => "required",
        ])->validate();
    }

    protected function authenticate($credentials)
    {
        try {
            if (!auth()->userOrFail()) {
                return $this->responseWithError("Email or Password is wrong!");
            }

            $token = JWTAuth::attempt($credentials);

            if (!$token) {
                return $this->responseWithError("Unauthorized");
            }
        } catch (JWTException $e) {
            $this->responseWithError($e->getMessage());
        }

        return $this->responseWithToken($token);
    }

    protected function disconnect()
    {
        try {
            JWTAuth::parseToken()->invalidate();
            return response()->json(["status" => "success", "message" => "User disconnected"]);
        } catch (JWTException $e) {
            return $this->responseWithError($e->getMessage());
        }
    }

    protected function responseWithToken($token)
    {
        return response()->json([
            "status" => "success",
            "token" => $token,
            "user" => auth()->user(),
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    protected function responseWithError($error)
    {
        return response()->json(["status" => "error", "error" => $error]);
    } */
}

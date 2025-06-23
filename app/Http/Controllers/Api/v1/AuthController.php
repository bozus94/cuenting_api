<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\hasAuthenticate;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    use hasAuthenticate;

    public function login(Request $request)
    {
        $credentials = $request->only(["email", "password"]);

        $this->loginValidate($credentials);

        $this->authenticate($credentials);
    }

    public function register(Request $request)
    {
        $data = $request->only(["name", "password", "email"]);

        $this->validateRegister($data);

        User::create([
            "name" => $request->name,
            "password" => $request->email,
            "email" => bcrypt($request->password)
        ]);

        $this->authenticate($request->only(["email", "password"]));
    }

    public function logout(Request $request)
    {
        $this->tokenValidate($request->only(["token"]));
    }
}

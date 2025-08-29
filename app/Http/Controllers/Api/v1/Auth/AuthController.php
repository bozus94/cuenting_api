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
}

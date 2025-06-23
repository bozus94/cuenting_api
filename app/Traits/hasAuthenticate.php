<?php

namespace App\Traits;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

trait hasAuthenticate
{
  protected function loginValidate($data)
  {
    $validator = Validator::make($data, [
      "email" => "required|email",
      "password" => "required|min:8"
    ]);

    if ($validator->fails()) {
      return $this->responseWithError($validator->messages());
    }
  }

  protected function validateRegister($data)
  {
    $validator = Validator::make($data, [
      "name" => "required|string",
      "email" => "required|email|unique:users",
      "password" => "required|min:8"
    ]);

    if ($validator->fails()) {
      return $this->responseWithError($validator->messages());
    }
  }

  protected function tokenValidate($data)
  {
    $validator = Validator::make($data, [
      "token" => "required",
    ]);

    if ($validator->fails()) {
      return $this->responseWithError($validator->messages());
    }
  }

  protected function authenticate($credentials)
  {
    try {
      if (!$token = JWTAuth::attempt($credentials)) {
        return $this->responseWithError("Unauthorized");
      }
    } catch (JWTException $e) {
      return $this->responseWithError($e->getMessage());
    }

    return $this->responseWithToken($token);
  }

  protected function disconnect($token)
  {
    try {
      JWTAuth::invalidate($token);
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
      "user" => Auth::user(),
      'expires_in' => auth()->factory()->getTTL() * 60
    ]);
  }

  protected function responseWithError($error)
  {
    return response()->json(["status" => "error", "error" => $error]);
  }
}

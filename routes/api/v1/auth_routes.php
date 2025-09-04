<?php

use Illuminate\Support\Facades\Route;
use App\Http\Api\v1\Controllers\AuthController;

Route::prefix("auth")->group(function () {
  Route::post("/register", [AuthController::class, "register"]);
  Route::post("/login", [AuthController::class, "login"]);
  Route::middleware(["verify_token"])->group(function () {
    Route::post("/me", [AuthController::class, "me"]);
    Route::post("/logout", [AuthController::class, "logout"]);
  });
});

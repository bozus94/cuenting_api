<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;

Route::prefix("auth")->group(function () {
  Route::post("/register", [AuthController::class, "register"]);
  Route::post("/login", [AuthController::class, "login"]);
  Route::middleware("auth:api")->group(function () {
    Route::post("/me", [AuthController::class, "me"]);
    Route::post("/logout", [AuthController::class, "logout"]);
  });
});

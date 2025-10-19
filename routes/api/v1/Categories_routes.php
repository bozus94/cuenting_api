<?php

use App\Http\Api\V1\Controllers\ExpenseCategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix("categories")->group(function () {
  Route::middleware("verify_token")->group(function () {
    Route::post("/expenses/create", [ExpenseCategoryController::class, "store"]);
  });
});

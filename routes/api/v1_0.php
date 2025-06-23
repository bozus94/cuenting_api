<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

Route::get('/', function (Request $request) {
  return "API ZONE: ADMIN V1.0";
});

require base_path("routes/api/v1/auth_routes.php");

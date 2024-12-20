<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function() {
    Route::post("v1/register", "register");
    Route::post("v1/login", "login");

    Route::get("v1/user", "userProfile")->middleware("auth:sanctum");
    Route::get("v1/logout", "logout")->middleware("auth:sanctum");
});

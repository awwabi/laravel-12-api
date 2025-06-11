<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'getUsers']);
    Route::post('/users', [UserController::class, 'create']);
});

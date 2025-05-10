<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GymProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::post('/login', [UserController::class, 'login']);
Route::apiResource('GymProduct', GymProductController::class);

?>

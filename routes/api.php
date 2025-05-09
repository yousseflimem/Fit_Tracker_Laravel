<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/test', function () {
    return ['status' => 'working'];
});
Illuminate\Support\Facades\Log::info('API ROUTES LOADED'); // Debug line

Route::get('/api-test', function() { die('API WORKS'); });
Route::get('/users', [UserController::class, 'index']);
Route::post('/signup', [UserController::class, 'signUp']);
?>


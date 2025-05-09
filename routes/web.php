<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\UserController;
Route::get('/', function () {
    return view('welcome');
});
Illuminate\Support\Facades\Log::info('WEB ROUTES LOADED'); // Debug line

Route::get('/web-test', function() { die('WEB WORKS'); });
// Route::get('/users', [UserController::class, 'index']);
// Route::post('/signup', [UserController::class, 'signUp']);
?>


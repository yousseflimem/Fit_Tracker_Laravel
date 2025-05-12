<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Now manually fetch the user (DO NOT use $request->user() or Auth::user())
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found after login'], 500);
    }

    $token = $user->createToken('auth-token')->plainTextToken;

    $message = $user->role === 'admin' ? 'Admin login successful' : 'User login successful';

    return response()->json([
        'message' => $message,
        'user' => $user,
        'token' => $token,
    ], 200);
}


}

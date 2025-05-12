<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\User;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $accessToken = $request->bearerToken();

        $tokenModel = \Laravel\Sanctum\PersonalAccessToken::findToken($accessToken);

        if (!$tokenModel) {
            return response()->json(['message' => 'Invalid or missing token'], 401);
        }

        $tokenModel->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

}

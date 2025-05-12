<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GymProduct;
use Laravel\Sanctum\PersonalAccessToken;

class AdminController extends Controller
{
    // Helper to get authenticated user from Bearer token
    private function getAuthenticatedUser(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) return null;

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken || !$accessToken->tokenable instanceof User) {
            return null;
        }

        return $accessToken->tokenable;
    }

    // List all users (only for Admin)
    public function listUsers(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);

        if (!$user || $user->role !== 'Admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['users' => User::all()]);
    }

    // Create new gym product (Admin only)
    public function createProduct(Request $request)
    {
        $user = $this->getAuthenticatedUser($request);

        if (!$user || $user->role !== 'Admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product = GymProduct::create($request->all());

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ]);
    }
}

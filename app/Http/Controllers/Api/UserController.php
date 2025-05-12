<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProductPurchase;
use App\Models\GymProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Handle user logout by invalidating the user's token.
     */
    public function logout(Request $request)
    {
        // Revoke the current user's token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Display the specified user.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified user details.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'sometimes|string|min:6|confirmed',
            'role' => ['sometimes', Rule::in(['Admin', 'User'])],
        ]);

        // Hash the password if it's updated
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Update user
        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }

    /**
     * Delete the specified user.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }

    /**
     * Purchase a product by the authenticated user.
     */
    public function purchaseProduct(Request $request, $productId)
{
    // Retrieve the token from the Authorization header
    $token = $request->bearerToken();
    \Log::info('Received Token: ' . $token);
    
    // Check if token is present
    if (!$token) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    // Verify token using Sanctum
    $accessToken = PersonalAccessToken::findToken($token);
    $user = $accessToken && $accessToken->tokenable instanceof User ? $accessToken->tokenable : null;

    if (!$user) {
        return response()->json(['error' => 'Invalid token'], 401);
    }

    try {
        // Validate the input
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the product and validate the price
        $product = GymProduct::findOrFail($productId);
        if (!isset($product->price) || !is_numeric($product->price)) {
            return response()->json(['error' => 'Invalid product price'], 400);
        }

        // Create the purchase record with the correct user_id
        $purchase = ProductPurchase::create([
            'user_id' => $user->id,  // Make sure this is correct
            'product_id' => $product->id,
            'quantity' => $request->input('quantity'),
            'price_at_purchase' => $product->price,
            'purchase_date' => now(),
        ]);

        return response()->json([
            'message' => 'Product purchased successfully',
            'purchase' => $purchase,
        ], 201);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Product not found'], 404);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
    } catch (\Exception $e) {
        \Log::error('Unexpected error', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Server error', 'message' => $e->getMessage()], 500);
    }
}


    /**
     * Look for a specific product purchase by the authenticated user.
     */
    public function lookForProduct(Request $request)
{
    $productId = $request->input('productid');

    // Get the token from the Authorization header
    $token = $request->bearerToken();

    if (!$token) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
    $user = $accessToken && $accessToken->tokenable instanceof \App\Models\User
        ? $accessToken->tokenable
        : null;

    if (!$user) {
        return response()->json(['error' => 'Invalid token'], 401);
    }

    // Find the product purchase record
    $purchase = \App\Models\ProductPurchase::where('user_id', $user->id)
        ->where('product_id', $productId)
        ->first();

    if ($purchase) {
        return response()->json(['message' => 'Product found', 'purchase' => $purchase], 200);
    } else {
        return response()->json(['error' => 'Product not found'], 404);
    }
}

}

<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\ProductPurchase;
use App\Models\GymProduct;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
/**
 * Handle user login
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */

    public function index()
    {
        $users = User::all();
        return response()->json($users, 200, [], JSON_PRETTY_PRINT);
    }
    public function logout(Request $request)
    {
                return response()->json(['message' => 'Logged out (fake logout - no auth used)']);

    }
    /**
     * Store a newly created resource in storage.
     */
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
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

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }

    
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
    $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
    $user = $accessToken ? $accessToken->tokenable : null;

    // If no user is found or the token is invalid
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
            \Log::error('Invalid product price', ['product_id' => $productId, 'price' => $product->price]);
            return response()->json(['error' => 'Invalid product price'], 400);
        }

        // Create the purchase record
        $purchase = ProductPurchase::create([
            'userid' => $user->id,
            'productid' => $product->id,
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















        
       

}?>
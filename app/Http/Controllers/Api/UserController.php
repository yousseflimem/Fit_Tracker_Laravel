<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    public function index()
    {
        $users = User::all();
         return response()->json($users, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         if (User::where('email', $request->email)->exists()) {
        return response()->json([
            'message' => 'Email already exists'
        ], 409); // 409 Conflict
    }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => ['nullable', Rule::in(['Admin', 'User'])], // Optional role field
        ]);
        

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'User', // Default to 'User' if not provided
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }

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
        $user = auth()->user();
        $product = GymProduct::findOrFail($productId);

        // Create purchase record (assuming you have a product_purchases table)
        $purchase = $user->productPurchases()->create([
            'product_id' => $productId,
            'purchase_date' => now(),
            // Add any other relevant purchase fields
        ]);

        return response()->json([
            'message' => 'Product purchased successfully',
            'purchase' => $purchase,
            'product' => $product
        ]);
    }
}?>
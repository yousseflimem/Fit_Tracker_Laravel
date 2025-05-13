<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\GymProduct;
use App\Models\Supplement;
use App\Models\Clothing;
use App\Models\Accessory;
use App\Models\ProductPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Review;
class AdminController extends Controller
{
    /**
     * List all users with pagination
     */
    public function listUsers(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $users = User::paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Add a new user
     */
    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:Admin,User',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);

            return response()->json([
                'success' => true,
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List all products with pagination
     */
    public function listAllProducts(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $products = GymProduct::with(['supplement', 'clothing', 'accessory'])
                            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function updateReview(Request $request, $reviewId)
    {
        $review = Review::find($reviewId);
        
        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $review->update($request->only(['rating', 'comment']));

            return response()->json([
                'success' => true,
                'data' => $review
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update review',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllReviews(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default to 10 reviews per page
        try {
            $reviews = Review::paginate($perPage); // Retrieve all reviews with pagination

            return response()->json([
                'success' => true,
                'data' => $reviews
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve reviews',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteReview($reviewId)
    {
        $review = Review::find($reviewId);
        
        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        try {
            $review->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete review',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Create any type of product
     */
    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:supplement,accessory,clothing',
            // Supplement specific
            'flavor' => 'required_if:category,supplement|string|max:255',
            'weight' => 'required_if:category,supplement|numeric|min:0',
            'form' => 'required_if:category,supplement|in:Powder,Capsule,Liquid',
            // Clothing specific
            'size' => 'required_if:category,clothing|in:S,M,L,XL',
            'color' => 'required_if:category,clothing|string|max:255',
            'gender' => 'required_if:category,clothing|in:Men,Women,Unisex',
            'material' => 'required_if:category,clothing|string|max:255',
            // Accessory specific
            'brand' => 'required_if:category,accessory|string|max:255',
            'accessory_size' => 'required_if:category,accessory|string|max:50',
            'accessory_weight' => 'required_if:category,accessory|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create base product
            $gymProduct = GymProduct::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'category' => $request->category,
            ]);

            // Create specific product based on category
            switch ($request->category) {
                case 'supplement':
                    $specificProduct = Supplement::create([
                        'productId' => $gymProduct->id,
                        'flavor' => $request->flavor,
                        'weight' => $request->weight,
                        'form' => $request->form,
                    ]);
                    break;
                
                case 'clothing':
                    $specificProduct = Clothing::create([
                        'productId' => $gymProduct->id,
                        'size' => $request->size,
                        'color' => $request->color,
                        'gender' => $request->gender,
                        'material' => $request->material,
                    ]);
                    break;
                
                case 'accessory':
                    $specificProduct = Accessory::create([
                        'productId' => $gymProduct->id,
                        'size' => $request->accessory_size,
                        'material' => $request->material,
                        'brand' => $request->brand,
                        'weight' => $request->accessory_weight,
                    ]);
                    break;
            }

            // Load the appropriate relationship based on category
            $gymProduct->load($request->category);

            return response()->json([
                'success' => true,
                'data' => $gymProduct
            ], 201);

        } catch (\Exception $e) {
            if (isset($gymProduct)) {
                $gymProduct->delete();
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update any product
     */
    public function updateProduct(Request $request, $id)
    {
        $product = GymProduct::find($id);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'size' => 'sometimes|string|max:50',
            'material' => 'sometimes|string|max:255',
            'flavor' => 'sometimes|string|max:255',
            'weight' => 'sometimes|numeric|min:0',
            'form' => 'sometimes|in:Powder,Capsule,Liquid',
            'color' => 'sometimes|string|max:255',
            'gender' => 'sometimes|in:Men,Women,Unisex',
            'brand' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $product->update($request->all());

            switch ($product->category) {
                case 'supplement':
                    if ($product->supplement) {
                        $product->supplement->update($request->only(['flavor', 'weight', 'form']));
                    }
                    break;
                
                case 'clothing':
                    if ($product->clothing) {
                        $product->clothing->update($request->only(['size', 'color', 'gender', 'material']));
                    }
                    break;
                
                case 'accessory':
                    if ($product->accessory) {
                        $product->accessory->update($request->only(['size', 'material', 'brand', 'weight']));
                    }
                    break;
            }

            $product->load($product->category);

            return response()->json([
                'success' => true,
                'data' => $product
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete any product
     */
    public function deleteProduct($id)
    {
        $product = GymProduct::find($id);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        try {
            $product->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

  
    /**
     * Modify a purchase
     */
    public function modifyPurchase(Request $request, $purchaseId)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'sometimes|integer|min:1',
            'price_at_purchase' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:completed,refunded,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $purchase = ProductPurchase::findOrFail($purchaseId);
            
            $purchase->fill($request->all());
            $purchase->save();

            return response()->json([
                'success' => true,
                'data' => $purchase
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to modify purchase',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getAllPurchases()
    {
            try {
                $purchases = ProductPurchase::all();  // Fetch all purchases from the database

                return response()->json([
                    'success' => true,
                    'data' => $purchases
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve purchases',
                    'error' => $e->getMessage()
                ], 500);
            }
        }


    /**
     * Update user details
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|min:6',
            'role' => 'sometimes|in:Admin,User',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updateData = $request->all();
            
            if ($request->has('password')) {
                $updateData['password'] = bcrypt($request->password);
            }

            $user->update($updateData);

            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a user
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        try {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
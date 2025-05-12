<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\GymProduct;
use App\Http\Controllers\Controller; 
class GymProductController extends Controller
{
    public function index()
    {
        $products = GymProduct::all();
        return response()->json($products, 200, [], JSON_PRETTY_PRINT);
    }


    public function show($id)
    {
        // Logic to fetch and return a specific gym product by ID
         $product = GymProduct::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json($product, 200, [], JSON_PRETTY_PRINT);
    }

    public function store(Request $request)
     {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:Supplement,Accessory,Clothing',
            'stock' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = GymProduct::create($request->all());

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    // Removed redundant update method declaration

     public function destroy($id)
    {
        $product = GymProduct::find($id);

        if (!$product) {
            return response()->json([
            'message' => 'Product not found'
            ], 404);
        }
        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = GymProduct::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'category' => 'sometimes|required|string|in:supplement,equipment,clothing',
            'stock' => 'sometimes|required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update($request->all());

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ], 200);
    }

}

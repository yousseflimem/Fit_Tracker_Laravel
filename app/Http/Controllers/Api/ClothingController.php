<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Models\GymProduct;
use App\Models\Clothing;
use Illuminate\Routing\Controller;
class ClothingController extends Controller{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gymProduct = GymProduct::where('category', 'clothing')->with('clothing')->get();
        $gymProduct->load('clothing');

        return response()->json($gymProduct);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'size' => 'required|in:S,M,L,XL',
                'color' => 'required|string|max:255',
                'gender' => 'required|in:Men,Women,Unisex',
                'material' => 'required|string|max:255',
            ]);

            $gymProduct = GymProduct::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'category' => 'clothing',
            ]);

            $clothing = Clothing::create([
                'productId' => $gymProduct->id,
                'size' => $validated['size'],
                'color' => $validated['color'],
                'gender' => $validated['gender'],
                'material' => $validated['material'],
            ]);

            return $gymProduct->load('clothing');
        } catch (\Exception $e) {
            \Log::error("Error creating clothing: " . $e->getMessage());

            return response()->json([
                'error' => 'An error occurred while creating the clothing item.',
                'message' => $e->getMessage()
            ], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gymProduct=GymProduct::where('category', 'clothing')->with('clothing')->find($id);
        if (!$gymProduct) {
            return response()->json(['message' => 'Supplement not found'], 404);
        }
        return response()->json($gymProduct);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gymProduct = GymProduct::where('category', 'clothing')->with('clothing')->find($id);
        if (!$gymProduct) {
            return response()->json(['message' => 'Supplement not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'size' => 'sometimes|required|in:S,M,L,XL',
            'color' => 'sometimes|required|string|max:255',
         ]);
        $clothing = $gymProduct->clothing;
        if ($clothing) {
            $clothing->update($validated);
        } else {
            return response()->json(['message' => 'Clothing not found'], 404);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gymProduct = GymProduct::where('category', 'clothing')->with('clothing')->find($id);
        if (!$gymProduct) {
            return response()->json(['message' => 'Supplement not found'], 404);
        }

        $gymProduct->delete();
        return response()->json(['message' => 'Supplement deleted successfully']);
    }
}

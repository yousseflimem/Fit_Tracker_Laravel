<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\GymProduct;
use App\Models\Accessory;
use Illuminate\Routing\Controller;
class AccessoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gymProduct = GymProduct::where('category', 'accessory')->with('accessory')->get();
        $gymProduct->load('accessory');

        return response()->json($gymProduct);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'size' => 'required|string|max:50',
                'material' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'weight' => 'required|numeric|min:0',
            ]);

            // Create a new GymProduct for the accessory
            $gymProduct = GymProduct::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'category' => 'accessory',
            ]);

            // Create the accessory linked to the GymProduct
            $accessory = Accessory::create([
                'productId' => $gymProduct->id,
                'material' => $validated['material'],
                'brand' => $validated['brand'],
                'size' => $validated['size'],
                'weight' => $validated['weight'],
            ]);

            // Return the created gym product with its accessory data
            return response()->json($gymProduct->load('accessory'), 201);
        } catch (\Exception $e) {
            // Log the error and return a response with the error message
            \Log::error("Error creating accessory: " . $e->getMessage());

            return response()->json([
                'error' => 'An error occurred while creating the accessory item.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gymProduct = GymProduct::where('category', 'accessory')->with('accessory')->find($id);

        if (!$gymProduct) {
            return response()->json(['error' => 'Accessory not found'], 404);
        }

        return response()->json($gymProduct);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gymProduct = GymProduct::where('category', 'accessory')->with('accessory')->find($id);

        if (!$gymProduct) {
            return response()->json(['error' => 'Accessory not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'size' => 'sometimes|required|string|max:50',
            'material' => 'sometimes|required|string|max:255',
            'brand' => 'sometimes|required|string|max:255',
            'weight' => 'sometimes|required|numeric|min:0',
        ]);

        $gymProduct->update($validated);

        return response()->json($gymProduct->load('accessory'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gymProduct = GymProduct::where('category', 'accessory')->with('accessory')->find($id);

        if (!$gymProduct) {
            return response()->json(['error' => 'Accessory not found'], 404);
        }

        $gymProduct->delete();

        return response()->json(['message' => 'Accessory deleted successfully']);
    }
}

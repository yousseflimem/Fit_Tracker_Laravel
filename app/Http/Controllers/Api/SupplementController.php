<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\GymProduct;
use App\Models\Supplement;
class SupplementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $gymProduct = GymProduct::where('category', 'supplement')->with('supplement')->get();
            $gymProduct->load('supplement');

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
                'flavor' => 'required|string|max:255',
                'weight' => 'required|numeric|min:0',
                'form' => 'required|in:Powder,Capsule,Liquid',
            ]);

            $gymProduct = GymProduct::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'category' => 'supplement',
            ]);

            $supplement = Supplement::create([
                'productId' => $gymProduct->id,  // Foreign key relation
                'flavor' => $validated['flavor'],
                'weight' => $validated['weight'],
                'form' => $validated['form'],
            ]);

            return $gymProduct->load('productable');
        } catch (\Exception $e) {
            \Log::error("Error creating supplement: " . $e->getMessage());

            // Return a response with the error message
            return response()->json([
                'error' => 'An error occurred while creating the supplement.',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gymProduct = GymProduct::where('category', 'supplement')->with('supplement')->find($id);
        if (!$gymProduct) {
            return response()->json(['message' => 'Supplement not found'], 404);
        }
        return response()->json($gymProduct);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gymProduct = GymProduct::where('category', 'supplement')->with('supplement')->find($id);
        if (!$gymProduct) {
            return response()->json(['message' => 'Supplement not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'flavor' => 'sometimes|required|string|max:255',
            'weight' => 'sometimes|required|numeric|min:0',
            'form' => 'sometimes|required|in:Powder,Capsule,Liquid',
        ]);

        $gymProduct->update($validated);

        return response()->json($gymProduct->load('productable'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gymProduct = GymProduct::where('category', 'supplement')->find($id);
        if (!$gymProduct) {
            return response()->json(['message' => 'Supplement not found'], 404);
        }

        $gymProduct->delete();

        return response()->json(['message' => 'Supplement deleted successfully']);
    }
}

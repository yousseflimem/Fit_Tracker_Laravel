<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\GymProduct;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Get all reviews, with optional filtering by product_id.
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product']);

        if ($request->has('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        $reviews = $query->get();

        return response()->json([
            'success' => true,
            'data'    => $reviews,
        ]);
    }

    /**
     * Store a new review.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:gym_products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:255',
        ]);

        $review = new Review();
        $review->user_id = Auth::id();
        $review->product_id = $request->input('product_id');
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->save();    
    }

    /**
     * Show a specific review by ID.
     */
    public function show($id)
    {
        $review = Review::with(['user', 'product'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $review,
        ]); 
    }

    /**
     * Update an existing review.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:255',
        ]);

        $review = Review::findOrFail($id);
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->save();

        return response()->json([
            'success' => true,
            'data' => $review,
        ]);
    }

    /**
     * Delete a review by ID.
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully',
        ]);
    }
}

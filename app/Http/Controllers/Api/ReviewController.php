<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\GymProduct;
use App\Models\User;
use Illuminate\Routing\Controller;

class ReviewController extends Controller
{
    /**
     * Get all reviews, optionally filtered by product_id.
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
    $token = $request->bearerToken();
    $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
    $user = $accessToken && $accessToken->tokenable instanceof User
        ? $accessToken->tokenable
        : null;

    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    $request->validate([
        'product_id' => 'required|exists:gym_products,id',
        'rating'     => 'required|integer|min:1|max:5',
        'comment'    => 'nullable|string|max:255',
    ]);

    $review = new Review();
    $review->user_id = $user->id; // use authenticated user
    $review->product_id = $request->input('product_id');
    $review->rating = $request->input('rating');
    $review->comment = $request->input('comment');
    $review->save();

    return response()->json([
        'success' => true,
        'data'    => $review,
    ]);
}

    /**
     * Show a specific review.
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
        try {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:255',
        ]);

        // Retrieve the review based on the provided ID
        $review = Review::findOrFail($id);  // Ensures the review exists or returns 404

        // Update fields
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');

        // Save the review - Laravel will automatically update `updated_at`
        $review->save();

        return response()->json([
            'success' => true,
            'data'    => $review,
        ]);
    } catch (\Exception $e) {
        // Log the exception message for debugging purposes
        \Log::error($e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Error occurred: ' . $e->getMessage()
        ], 500);
    }
    }

    /**
     * Delete a review.
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

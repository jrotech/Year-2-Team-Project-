<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:10000',
        ]);

        // Check if user is authenticated
        if (!Auth::guard('customer')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to submit a review.'
            ], 401);
        }

        $customerId = Auth::guard('customer')->id();

        // Check if the customer has already reviewed this product
        $existingReview = Review::where('product_id', $validated['product_id'])
            ->where('customer_id', $customerId)
            ->first();

        if ($existingReview) {
            // Update the existing review
            $existingReview->update([
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? $existingReview->comment,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your review has been updated.',
                'review' => $existingReview
            ]);
        }

        // Create a new review
        $review = Review::create([
            'product_id' => $validated['product_id'],
            'customer_id' => $customerId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? '',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your review has been submitted.',
            'review' => $review
        ], 201);
    }

    /**
     * Get reviews for a product.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\Response
     */
    public function getProductReviews($productId)
    {
        $product = Product::findOrFail($productId);

        $reviews = Review::where('product_id', $productId)
            ->with('customer:id,customer_name')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $averageRating = $product->average_rating;
        $reviewsCount = $product->reviews_count;

        // Get rating distribution
        $ratingDistribution = [
            5 => $product->reviews()->where('rating', 5)->count(),
            4 => $product->reviews()->where('rating', 4)->count(),
            3 => $product->reviews()->where('rating', 3)->count(),
            2 => $product->reviews()->where('rating', 2)->count(),
            1 => $product->reviews()->where('rating', 1)->count()
        ];

        return response()->json([
            'product_id' => $productId,
            'average_rating' => $averageRating,
            'reviews_count' => $reviewsCount,
            'rating_distribution' => $ratingDistribution,
            'reviews' => $reviews
        ]);
    }

    /**
     * Update the specified review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        // Check if the authenticated customer owns this review
        if (Auth::guard('customer')->id() !== $review->customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this review.'
            ], 403);
        }

        // Validate the request
        $validated = $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:10000',
        ]);

        // Update the review
        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? '',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your review has been updated.',
            'review' => $review
        ]);
    }

    /**
     * Remove the specified review from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Check if the authenticated customer owns this review
        if (Auth::guard('customer')->id() !== $review->customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this review.'
            ], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Your review has been deleted.'
        ]);
    }

    /**
     * Get a customer's reviews
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomerReviews()
    {
        if (!Auth::guard('customer')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to view your reviews.'
            ], 401);
        }

        $customerId = Auth::guard('customer')->id();

        $reviews = Review::where('customer_id', $customerId)
            ->with('product:id,name,price,image')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'reviews' => $reviews
        ]);
    }
}

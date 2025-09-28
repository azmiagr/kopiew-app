<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Review;
use Illuminate\Http\Request;
use ResponseHelper;

class ReviewController extends Controller
{

    public function index()
    {
        $reviews = Review::with('comments', 'place')->get();

        return ResponseHelper::success($reviews, "Success to get all reviews");
    }

    public function show(Place $place)
    {
        $reviews = $place->reviews()->with('comments', 'user')->get();

        return ResponseHelper::success($reviews, "Success to get all reviews");
    }

    public function store(Request $request, Place $place)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $data = array_merge($validated, ['user_id' => auth()->id()]);
        $reviews = $place->reviews()->create($data);

        return ResponseHelper::success($reviews, "Success to create review", 201);
    }

    public function update(Request $request, Place $place, Review $review)
    {
        if ($review->place_id !== $place->id) {
            return ResponseHelper::error("This review does not belong to the given place", 400);
        }

        if ($review->user_id !== auth()->id()) {
            return ResponseHelper::error("You are not authorized to edit this review", 403);
        }

        $validated = $request->validate([
            'content' => 'sometimes|string',
            'rating' => 'sometimes|integer|min:1|max:5'
        ]);

        $review->update($validated);

        return ResponseHelper::success($review, "Success to update review");
    }

    public function destroy(Place $place, Review $review)
    {
        if ($review->place_id !== $place->id) {
            return ResponseHelper::error("This review does not belong to the given place", 400);
        }

        if ($review->user_id !== auth()->id()) {
            return ResponseHelper::error("You are not authorized to delete this review", 403);
        }

        $review->delete();

        return ResponseHelper::success(null, "Success to delete review");
    }
}

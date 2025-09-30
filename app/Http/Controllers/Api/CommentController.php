<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Review;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * GET
     */
    public function index($place_id, $review_id)
    {
        $review = Review::where('place_id', $place_id)->findOrFail($review_id);

        return Comment::with('user')
            ->where('review_id', $review->id)
            ->get();
    }

    /**
     * POST
     */
    public function store(Request $request, $place_id, $review_id)
    {
        $review = Review::where('place_id', $place_id)->findOrFail($review_id);

        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment = Comment::create([
            'content' => $validated['content'],
            'user_id' => auth()->id(), 
            'review_id' => $review->id,
        ]);

        return response()->json([
            'message' => 'Comment created successfully',
            'data' => $comment,
        ], 201);
    }

    /**
     * PUT
     */
    public function update(Request $request, $place_id, $review_id, $comment_id)
    {
        $review = Review::where('place_id', $place_id)->findOrFail($review_id);
        $comment = Comment::where('review_id', $review->id)->findOrFail($comment_id);

        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment->update([
            'content' => $validated['content'],
        ]);

        return response()->json([
            'message' => 'Comment updated successfully',
            'data' => $comment,
        ]);
    }

    /**
     * DELETE
     */
    public function destroy($place_id, $review_id, $comment_id)
    {
        $review = Review::where('place_id', $place_id)->findOrFail($review_id);
        $comment = Comment::where('review_id', $review->id)->findOrFail($comment_id);

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully'
        ]);
    }
}
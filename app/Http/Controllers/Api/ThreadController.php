<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadLike;
use App\Models\ThreadComment;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::with(['comments.user'])->latest()->get();
        return response()->json($threads);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->hasFile('image')
            ? $request->file('image')->store('threads', 'public')
            : null;

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'image' => $path,
            'likes_count' => 0,
            'comments_count' => 0,
        ]);

        return response()->json([
            'message' => 'Thread berhasil dibuat!',
            'data' => $thread
        ], 201);
    }

    public function show(Thread $thread)
    {
        $thread->load(['comments.user']);
        return response()->json($thread);
    }

    public function update(Request $request, Thread $thread)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->hasFile('image')
            ? $request->file('image')->store('threads', 'public')
            : $thread->image;

        $thread->update([
            'content' => $request->content,
            'image' => $path,
        ]);

        return response()->json([
            'message' => 'Thread berhasil diupdate!',
            'data' => $thread
        ]);
    }

    public function destroy(Thread $thread)
    {
        $thread->delete();
        return response()->json([
            'message' => 'Thread berhasil dihapus!'
        ]);
    }

    public function like(Thread $thread)
    {
        $userId = auth()->id();

        $existing = ThreadLike::where('thread_id', $thread->id)
            ->where('user_id', $userId)
            ->first();

        if ($existing) {
            $existing->delete();
            $thread->decrement('likes_count');
            $message = 'Unliked';
        } else {
            ThreadLike::create([
                'thread_id' => $thread->id,
                'user_id' => $userId,
            ]);
            $thread->increment('likes_count');
            $message = 'Liked';
        }

        return response()->json([
            'message' => $message,
            'likes_count' => $thread->likes_count,
        ]);
    }

    public function addComment(Request $request, Thread $thread)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = ThreadComment::create([
            'user_id' => auth()->id(),
            'thread_id' => $thread->id,
            'comment' => $request->comment,
        ]);

        $thread->increment('comments_count');

        return response()->json([
            'message' => 'Comment added!',
            'data' => $comment
        ], 201);
    }
}
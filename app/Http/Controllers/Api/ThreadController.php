<?php

namespace App\Http\Controllers\Api;

use App\Models\Thread;
use App\Models\ThreadLike;
use App\Models\ThreadComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ResponseHelper;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::with(['user', 'comments.user'])->latest()->paginate(8);
        return ResponseHelper::success($threads, "Thread berhasil diambil");
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

        return ResponseHelper::success($thread, 'Thread berhasil dibuat.', 201);
    }

    public function show(Thread $thread)
    {
        $thread->load(['user', 'comments.user']);
        return ResponseHelper::success($thread, 'Detail thread berhasil diambil.');
    }

    public function update(Request $request, Thread $thread)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($thread->user_id !== auth()->id()) {
            return ResponseHelper::error('Unauthorized', 403);
        }

        $path = $request->hasFile('image')
            ? $request->file('image')->store('threads', 'public')
            : $thread->image;

        $thread->update([
            'content' => $request->content,
            'image' => $path,
        ]);

        return ResponseHelper::success($thread, 'Thread berhasil diupdate.');
    }

    public function destroy(Thread $thread)
    {
        if ($thread->user_id !== auth()->id()) {
            return ResponseHelper::error('Unauthorized', 403);
        }

        $thread->delete();
        return ResponseHelper::success(null, 'Thread berhasil dihapus.');
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

        return ResponseHelper::success([
            'likes_count' => $thread->likes_count,
        ], $message);
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

        return ResponseHelper::success($comment, 'Comment ditambahkan.', 201);
    }
}

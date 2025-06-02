<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Post $post): JsonResponse
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user = Auth::guard('sanctum')->user();

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $user?->id,
            'content' => $request->content,
        ]);

        $comment->load('user');

        return response()->json($comment, 201);
    }

    public function destroy(Comment $comment): JsonResponse
    {    
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json(null, 204);
    }
}

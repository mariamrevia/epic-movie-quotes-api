<?php

namespace App\Http\Controllers;

use App\Http\Requests\quote\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request): JsonResponse
    {
        $comment = Comment::create($request->validated() +  ['user_id' => auth()->id()]);
        return response()->json($comment, 200);

    }
}

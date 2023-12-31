<?php

namespace App\Http\Controllers\quote;

use App\Events\CommentPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\quote\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request): JsonResource
    {
        $comment = Comment::create($request->validated() +  ['user_id' => auth()->id()]);
        $image = auth()->user()->image;

        event(new CommentPosted($comment, $image));
        return CommentResource::make($comment);

    }
}

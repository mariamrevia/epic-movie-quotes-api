<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => $this->author->username,

        ];
    }
}

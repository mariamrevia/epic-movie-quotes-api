<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $movie = $this->movie;
        $comments = Comment::where('quote_id', $this->id)->get();
        $like = Like::where('quote_id', $this->id)->get();

        return [
            'id' => $this->id,
            'movie_id' => $this->movie_id,
            'body' => $this->getTranslations('body'),
            'image' => $this->image,
            'movie' => [
                'name' => $movie->getTranslations('name'),
                'year' => $movie->year,
                'user' =>  $movie->author->username,
                'image'=>$movie->author->image,
            ],
            'comments' => CommentResource::collection($comments),
            'likes' => LikeResource::collection($like),


        ];
    }


}

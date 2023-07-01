<?php

namespace App\Http\Resources;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'name'=> $this->getTranslations('name'),
            'description'=> $this->getTranslations('description'),
            'director'=> $this->getTranslations('director'),
            'year'=>$this->year,
            'image'=>$this->image,
            'genres' => GenreResource::collection($this->genres),
            'quotes'=>QuoteResource::collection($this->quotes)

];



    }
}

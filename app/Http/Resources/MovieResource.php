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
            'name'=>['en'=> $this->getTranslation('name', 'en') ,'ka'=> $this->getTranslation('name', 'ka') ],
            'description'=>['en'=> $this->getTranslation('description', 'en') ,'ka'=> $this->getTranslation('description', 'ka') ],
            'director'=>['en'=> $this->getTranslation('director', 'en') ,'ka'=> $this->getTranslation('director', 'ka') ],
            'release_date'=>$this->release_date,
            'image'=>$this->image,

        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    public function toArray(Request $request): array
    {


        return [
            'id' => $this->id,
            'quote_id' => $this->quote_id,
            'user_id' => $this->user_id,



        ];
    }
}

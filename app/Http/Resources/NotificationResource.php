<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'to'=> $this->to,
            'image'=>$this->image,
            'username'=>$this->username,
            'action_type'=>$this->action_type,
            'is_read'=>$this->is_read,
            'created_at'=>$this->created_at
        ];
    }
}

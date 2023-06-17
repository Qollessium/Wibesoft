<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OnlyTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'is_done' => $this->is_done,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'assigned_at' => $this->pivot->assigned_at,
            'is_user_done' => $this->pivot->is_done 
        ];
    }
}

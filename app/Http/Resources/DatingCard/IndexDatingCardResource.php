<?php

namespace App\Http\Resources\DatingCard;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexDatingCardResource extends JsonResource
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
            'id' => $this->id ?? null,
            'name' => $this->name ?? null,
            'about' => $this->about ?? null,
            'gender' => $this->gender ?? null,
            'seeking_for' => $this->seeking_for ?? null,
            'user_id' => $this->user_id ?? null,
            'published_at' => $this->published_at ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
            'tags' => isset($this->tags) ? array_column($this->tags->toArray(), 'name') : null,
        ];
    }
}

<?php

namespace App\Http\Resources\Artist;

use Illuminate\Http\Resources\Json\JsonResource;

class Index extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid'         => $this->uuid,
            'name' => $this->name,
            'image'        => $this->getFirstMediaUrl('artist'),
            'created_at' => $this->created_at?->format('d M Y'),
        ];
    }
}

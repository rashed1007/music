<?php

namespace App\Http\Resources\Artist;

use App\Http\Resources\Album\Index;
use Illuminate\Http\Resources\Json\JsonResource;

class Show extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid'         => $this->uuid,
            'name' => $this->name,
            'image'        => $this->getFirstMediaUrl('artist'),
            'created_at' => $this->created_at?->format('d M Y'),
            'albums' => Index::collection($this->albums()?->get()),

        ];
    }
}

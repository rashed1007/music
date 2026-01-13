<?php

namespace App\Http\Resources\Album;

use App\Http\Resources\Song\Index;
use Illuminate\Http\Resources\Json\JsonResource;

class Show extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid'        => $this->uuid,
            'name'        => $this->name,
            'year'        => $this->year,
            'artist_id'   => $this->artist_id,
            'artist_name' => $this->artist_name,
            'image'       => $this->getFirstMediaUrl('album'),
            'created_at'  => $this->created_at?->format('d M Y'),
            'songs' => Index::collection($this->songs()?->get()),
        ];
    }
}

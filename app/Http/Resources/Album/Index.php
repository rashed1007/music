<?php

namespace App\Http\Resources\Album;

use Illuminate\Http\Resources\Json\JsonResource;

class Index extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid'        => $this->uuid,
            'name'        => $this->name,
            'year'        => $this->year,
            'artist_name' => $this->artist_name,
            'image'       => $this->getFirstMediaUrl('album'),
            'created_at'  => $this->created_at?->format('d M Y'),
        ];
    }
}

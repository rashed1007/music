<?php

namespace App\Http\Requests\Song;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'artist_id' => 'sometimes|exists:artists,id',
            'album_id'  => 'sometimes|exists:albums,id',
            'name'      => 'sometimes|string|max:255',
            'year'      => 'sometimes|string|max:4',
            'file'      => 'sometimes|file|mimes:mp3,wav,ogg|max:10240',
        ];
    }
}

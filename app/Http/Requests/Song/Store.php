<?php

namespace App\Http\Requests\Song;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'artist_id' => 'required|exists:artists,id',
            'album_id'  => 'required|exists:albums,id',
            'name'      => 'required|string|max:255',
            'year'      => 'required|string|max:4',
            'file'      => 'nullable|file|mimes:mp3,wav,ogg,mp4|max:10240',
        ];
    }
}

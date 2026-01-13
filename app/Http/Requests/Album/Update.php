<?php

namespace App\Http\Requests\Album;

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
            'name'      => 'sometimes|string|max:255',
            'year'      => 'sometimes|string|max:4',
            'image'     => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}

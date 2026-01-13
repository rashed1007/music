<?php

namespace App\Http\Requests\Album;

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
            'name'      => 'required|string|max:255',
            'year'      => 'required|string|max:4',
            'image'     => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}

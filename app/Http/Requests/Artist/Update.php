<?php

namespace App\Http\Requests\Artist;

use Illuminate\Validation\Rule;
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('artists', 'name')->ignore($this->route('artist')),
            ],

            'alive' => 'sometimes|boolean',

            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:2048',

        ];
    }
}

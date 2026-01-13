<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'lang'  => 'nullable|in:ar,en',

            'logo'      => 'required|image|mimes:jpg,jpeg,png|max:2048',

        ];
    }
}

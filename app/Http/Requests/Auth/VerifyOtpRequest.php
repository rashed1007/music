<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|exists:users,phone',
            'otp'   => 'required|digits:4',
        ];
    }
}

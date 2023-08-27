<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required|string|size:50',
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ];
    }

}

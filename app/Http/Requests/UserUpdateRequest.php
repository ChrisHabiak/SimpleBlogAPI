<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:15',
            'password' => 'nullable|string|min:8',
            'email' => 'required|email|unique:users,email,'.$this->id.',id',
            'role_id' => 'nullable|exists:roles,id',
        ];
    }

}

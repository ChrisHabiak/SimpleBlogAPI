<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:15',
            'password' => 'required|string|min:8',
            'email' => 'required|email|max:255|unique:users',
            'role_id' => 'nullable|exists:roles,id',
        ];
    }

}

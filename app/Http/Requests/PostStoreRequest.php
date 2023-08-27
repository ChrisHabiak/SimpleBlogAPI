<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048',
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:3|max:65535'
        ];
    }

}

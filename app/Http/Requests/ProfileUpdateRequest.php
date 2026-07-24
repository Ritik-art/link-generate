<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user()->id,
        ];
    }
}

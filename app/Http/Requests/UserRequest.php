<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ];
    }
}

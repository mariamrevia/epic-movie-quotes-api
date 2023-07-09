<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required_if:anotherfield,value',
            'email' => 'nullable|required_if:anotherfield,value|email',
            'password' => 'required_if:anotherfield,value|confirmed',
            'image'=>'sometimes|required'
        ];
    }
}

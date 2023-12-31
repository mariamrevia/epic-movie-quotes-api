<?php

namespace App\Http\Requests\quote;

use Illuminate\Foundation\Http\FormRequest;

class StoreLikeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quote_id' => 'required|exists:quotes,id',

        ];
    }
}

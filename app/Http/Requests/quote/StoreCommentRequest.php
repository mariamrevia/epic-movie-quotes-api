<?php

namespace App\Http\Requests\quote;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'body'=> 'required',
            'quote_id'=>'required'
        ];
    }
}

<?php

namespace App\Http\Requests\quote;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [

            'body.en'=>'required',
            'body.ka'=>'required',
            'image'=>'required',





        ];
    }
}

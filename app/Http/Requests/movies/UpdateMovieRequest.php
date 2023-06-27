<?php

namespace App\Http\Requests\movies;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name.en' => 'required',
            'name.ka' => 'required',
            'director.en'=>'required',
            'director.ka'=>'required',
            'description.en'=>'required',
            'description.ka'=>'required',
            'year'=>'required',
            'genre' => 'required',
            'image'=>'required'
        ];
    }
}

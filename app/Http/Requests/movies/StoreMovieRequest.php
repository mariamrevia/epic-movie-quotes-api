<?php

namespace App\Http\Requests\movies;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name.en' => 'required|unique:movies,name->en',
            'name.ka' => 'required|unique:movies,name->ka',
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

<?php

namespace App\Http\Requests\movies;

use App\Models\Movie;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    public function rules(): array
    {
        $movie = Movie::findOrFail(request()->route('movieId'));
        return [
            'name.en' => 'required|unique:movies,name->en,' . $movie->id,
            'name.ka' => 'required|required|unique:movies,name->ka,' . $movie->id,
            'director.en'=>'required',
            'director.ka'=>'required',
            'description.en'=>'required',
            'description.ka'=>'required',
            'year'=>'required',
            'genres' => 'required',
            'image'=>'sometimes|image'
        ];
    }
}

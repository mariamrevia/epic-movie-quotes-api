<?php

namespace App\Http\Controllers;

use App\Http\Requests\movies\StoreMovieRequest;
use App\Http\Requests\movies\UpdateMovieRequest;
use App\Http\Resources\GenreResource;
use App\Models\Movie;
use App\Http\Resources\MovieResource;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function show(): JsonResponse
    {
        $genres = GenreResource::collection(Genre::all());
        $movies = Movie::filter(['search' => request('search') ?? ''])->get();

        return response()->json([
            'movies' => MovieResource::collection($movies),
            'genres' => $genres,
        ]);
    }



    public function store(StoreMovieRequest $request): JsonResponse
    {

        $movie = Movie::create([...$request->validated(), 'image' => $request->file('image')->store('images')]

        + ['user_id' => auth()->id()]);

        $genres = $request->validated(['genre']);

        foreach ($genres as $genreId) {
            $movie->genres()->attach($genreId);

        }
        return response()->json(MovieResource::make($movie), 201);
    }

    public function update(UpdateMovieRequest $request, $movieId): JsonResponse
    {
        $movie = Movie::findOrFail($movieId);

        $validatedData = $request->validated();


        if ($request->hasFile('image')) {
            Storage::delete($movie->image);
            $validatedData['image'] = $request->file('image')->store('images');
        }
        $movie->update($validatedData);
        if (isset($validatedData['genres'])) {
            $genreIds = $validatedData['genres'];
            $movie->genres()->sync($genreIds);
        }

        return response()->json(MovieResource::make($movie), 200);
    }

}

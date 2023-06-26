<?php

namespace App\Http\Controllers;

use App\Http\Requests\movies\StoreMovieRequest;
use App\Models\Movie;
use App\Http\Resources\MovieResource;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function show(): JsonResponse
    {

        $genres = Genre::all();
        $movies = MovieResource::collection(auth()->user()->movies);

        return response()->json([
            'movies' => $movies,
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
        return response()->json($movie, 201);
    }

}

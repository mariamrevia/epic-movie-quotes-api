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
    public function index(): JsonResource
    {
        $genres = GenreResource::collection(Genre::all());
        $movies = Movie::filter(['search' => request('search') ?? ''])
            ->where('user_id', auth()->id())
            ->get();

        return MovieResource::collection($movies)
            ->additional(['genres' => $genres]);
    }

    public function store(StoreMovieRequest $request): JsonResource
    {


        $movie = Movie::create([...$request->validated(), 'image' => $request->file('image')->store('images'),'user_id' => auth()->id()]);



        $genres = $request->validated(['genre']);

        foreach ($genres as $genreId) {
            $movie->genres()->attach($genreId);

        }
        return MovieResource::make($movie);
    }

    public function update(UpdateMovieRequest $request, $movieId): JsonResource
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

        return MovieResource::make($movie);
    }



    public function destroy(Movie $movie): JsonResponse
    {
        $movie->delete();
        return response()->json();
    }
}

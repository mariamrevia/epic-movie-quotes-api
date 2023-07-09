<?php

namespace App\Http\Controllers;

use App\Http\Requests\quote\StoreLikeRequest;
use App\Http\Resources\LikeResource;
use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeController extends Controller
{
    public function store(StoreLikeRequest $request): JsonResource
    {



        $like =  Like::updateOrCreate(
            $request->validated() + ['user_id' => auth()->id()]
        );

        return LikeResource::make($like);
    }




}

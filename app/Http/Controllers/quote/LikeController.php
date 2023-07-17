<?php

namespace App\Http\Controllers\quote;

use App\Events\LikeNotification;
use App\Http\Controllers\Controller;
use App\Events\LikeQuote;
use App\Events\UnLikeQuote;
use App\Http\Requests\quote\StoreLikeRequest;
use App\Http\Resources\LikeResource;
use App\Models\Like;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    public function store(StoreLikeRequest $request): JsonResource
    {


        $like =  Like::create(
            $request->validated() + ['user_id' => auth()->id()]
        );
        event(new LikeQuote($like));
        return LikeResource::make($like);
    }

    public function destroy(Quote $quoteId): JsonResponse
    {


        $like = $quoteId->likes()->where('user_id', auth()->id())->first();
        event(new UnLikeQuote($like));
        $like->delete();
        return response()->json(204);
    }




}

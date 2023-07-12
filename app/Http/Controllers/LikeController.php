<?php

namespace App\Http\Controllers;

use App\Events\LikeQuote;
use App\Events\UnLikeQuote;
use App\Http\Requests\quote\StoreLikeRequest;
use App\Http\Resources\LikeResource;
use App\Models\Like;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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

    public function destroy($id): JsonResponse
    {
        $quote = Quote::find($id);

        $like = $quote->likes()->where('user_id', auth()->id())->first();
        event(new UnLikeQuote($like));
        $like->delete();
        return response()->json(204);
    }




}

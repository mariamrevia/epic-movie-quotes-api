<?php

namespace App\Http\Controllers;

use App\Http\Requests\quote\StoreQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteContoller extends Controller
{
    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $quote = Quote::create([...$request->validated(), 'image' => $request->file('image')->store('images')]);
        return response()->json($quote, 200);
    }

}

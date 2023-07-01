<?php

namespace App\Http\Controllers;

use App\Http\Requests\quote\StoreQuoteRequest;
use App\Http\Requests\quote\UpdateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class QuoteContoller extends Controller
{
    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $quote = Quote::create([...$request->validated(), 'image' => $request->file('image')->store('images')]);
        return response()->json($quote, 200);
    }

    public function update(UpdateQuoteRequest $request, $quoteId): JsonResponse
    {

        $quote = Quote::findOrFail($quoteId);
        $quoteAttributes = $request->validated();

        if ($request->hasFile('image')) {
            Storage::delete($quote->image);
            $quoteAttributes['image'] = $request->file('image')->store('images');
        }

        $quote->update($quoteAttributes);
        return response()->json($quote, 200);
    }

}

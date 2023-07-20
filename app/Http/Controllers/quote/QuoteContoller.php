<?php

namespace App\Http\Controllers\quote;

use App\Http\Requests\quote\StoreQuoteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\quote\UpdateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class QuoteContoller extends Controller
{
    public function index(Request $request): JsonResource
    {
        $page = request('page') ?? 1;

        $quotes = Quote::filter(['search' => request('search') ?? ''])
            ->latest()
            ->simplePaginate(5, ['*'], 'page', $page);

        return QuoteResource::collection($quotes);
    }

    public function store(StoreQuoteRequest $request): JsonResource
    {
        $quote = Quote::create([...$request->validated(), 'image' => $request->file('image')->store('images')]);
        return QuoteResource::make($quote);
    }

    public function update(UpdateQuoteRequest $request, Quote $quote): JsonResource
    {
        $quoteAttributes = $request->validated();

        if ($request->hasFile('image')) {
            Storage::delete($quote->image);
            $quoteAttributes['image'] = $request->file('image')->store('images');
        }

        $quote->update($quoteAttributes);
        return QuoteResource::make($quote);
    }

    public function destroy(Quote $quote): JsonResponse
    {
        $quote->delete();
        return response()->json('quote deleted');
    }

}

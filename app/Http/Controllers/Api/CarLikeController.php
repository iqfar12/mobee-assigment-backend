<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CarLikeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $reactions = $request->user()->carLikes()->with('car')->get();

        return response()->json([
            'liked_cars' => $reactions->where('type', 1)->pluck('car')->values(),
            'disliked_cars' => $reactions->where('type', 0)->pluck('car')->values(),
        ]);
    }

    public function store(Request $request, Car $car): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'boolean'],
        ]);

        $request->user()->carLikes()->updateOrCreate(
            ['car_id' => $car->id],
            ['type' => $validated['type']],
        );

        $message = $validated['type'] ? 'Car liked.' : 'Car disliked.';

        return response()->json(['message' => $message], 201);
    }

    public function destroy(Request $request, Car $car): Response
    {
        $request->user()->carLikes()->where('car_id', $car->id)->delete();

        return response()->noContent();
    }

    public function resetLike(Request $request): Response
    {
        $request->user()->carLikes()->delete();

        return response()->noContent();
    }
}

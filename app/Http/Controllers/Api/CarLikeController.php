<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarLike;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CarLikeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $likes = $request->user()
            ->carLikes()
            ->with('car')
            ->get()
            ->pluck('car');

        return response()->json($likes);
    }

    public function store(Request $request, Car $car): JsonResponse
    {
        $request->user()->carLikes()->firstOrCreate(['car_id' => $car->id]);

        return response()->json(['message' => 'Car liked.'], 201);
    }

    public function destroy(Request $request, Car $car): Response
    {
        CarLike::where('user_id', $request->user()->id)
            ->where('car_id', $car->id)
            ->delete();

        return response()->noContent();
    }
}

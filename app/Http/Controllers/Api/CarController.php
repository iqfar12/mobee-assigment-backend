<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\JsonResponse;

class CarController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Car::all());
    }

    public function show(Car $car): JsonResponse
    {
        return response()->json($car);
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::withCount('carLikes')->get();

        return response()->json($users);
    }

    public function show(User $user): JsonResponse
    {
        $likedCars = $user->carLikes()->where('type', 1)->with('car')->get()->pluck('car');

        return response()->json([
            'user' => $user,
            'liked_cars' => $likedCars,
        ]);
    }
}

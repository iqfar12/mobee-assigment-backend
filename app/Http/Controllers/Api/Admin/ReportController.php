<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarLike;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::query()->where('is_admin', false)->get();

        $report = $users->map(fn (User $user) => [
            'user' => $user->only('id', 'name', 'email'),
            'preferences' => $this->buildPreferences($user->id),
        ]);

        return response()->json($report);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'user' => $user->only('id', 'name', 'email'),
            'preferences' => $this->buildPreferences($user->id),
        ]);
    }

    private function buildPreferences(int $userId): array
    {
        $likes = CarLike::query()->where('user_id', $userId)->where('car_likes.type', 1)->with('car')->get();

        if ($likes->isEmpty()) {
            return [
                'most_liked_brand' => null,
                'most_liked_model' => null,
                'most_liked_type' => null,
            ];
        }

        $cars = $likes->pluck('car');

        return [
            'most_liked_brand' => $cars->groupBy('brand')->map->count()->sortDesc()->keys()->first(),
            'most_liked_model' => $cars->groupBy('model')->map->count()->sortDesc()->keys()->first(),
            'most_liked_type' => $cars->groupBy('type')->map->count()->sortDesc()->keys()->first(),
        ];
    }
}

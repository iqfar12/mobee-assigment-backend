<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarLike;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function index(): Response
    {
        $users = User::where('is_admin', false)
            ->withCount('carLikes')
            ->latest()
            ->get();

        $report = $users->map(function (User $user) {
            $likes = CarLike::where('user_id', $user->id)->with('car')->get();
            $cars = $likes->pluck('car');

            return [
                'user' => $user->only('id', 'name', 'email', 'created_at'),
                'car_likes_count' => $likes->count(),
                'most_liked_brand' => $cars->isNotEmpty()
                    ? $cars->groupBy('brand')->map->count()->sortDesc()->keys()->first()
                    : null,
                'most_liked_model' => $cars->isNotEmpty()
                    ? $cars->groupBy('model')->map->count()->sortDesc()->keys()->first()
                    : null,
                'most_liked_type' => $cars->isNotEmpty()
                    ? $cars->groupBy('type')->map->count()->sortDesc()->keys()->first()
                    : null,
            ];
        });

        return Inertia::render('admin/reports/index', [
            'report' => $report,
        ]);
    }
}

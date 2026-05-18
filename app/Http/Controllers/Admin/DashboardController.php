<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarLike;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $totalUsers = User::where('is_admin', false)->count();
        $totalCars = Car::count();
        $totalLikes = CarLike::count();

        $topBrand = CarLike::join('cars', 'car_likes.car_id', '=', 'cars.id')
            ->selectRaw('cars.brand, COUNT(*) as count')
            ->groupBy('cars.brand')
            ->orderByDesc('count')
            ->value('brand');

        $topModel = CarLike::join('cars', 'car_likes.car_id', '=', 'cars.id')
            ->selectRaw('cars.model, COUNT(*) as count')
            ->groupBy('cars.model')
            ->orderByDesc('count')
            ->value('model');

        $topType = CarLike::join('cars', 'car_likes.car_id', '=', 'cars.id')
            ->selectRaw('cars.type, COUNT(*) as count')
            ->groupBy('cars.type')
            ->orderByDesc('count')
            ->value('type');

        $recentUsers = User::where('is_admin', false)
            ->withCount('carLikes')
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('admin/dashboard', [
            'stats' => [
                'total_users' => $totalUsers,
                'total_cars' => $totalCars,
                'total_likes' => $totalLikes,
                'top_brand' => $topBrand,
                'top_model' => $topModel,
                'top_type' => $topType,
            ],
            'recent_users' => $recentUsers,
        ]);
    }
}

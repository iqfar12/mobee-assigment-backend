<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $totalUsers = User::query()->where('is_admin', false)->count();
        $totalCars = DB::table('cars')->count();
        $totalLikes = DB::table('car_likes')->where('type', 1)->count();

        $topBrand = DB::table('car_likes')
            ->join('cars', 'car_likes.car_id', '=', 'cars.id')
            ->where('car_likes.type', 1)
            ->selectRaw('cars.brand, COUNT(*) as count')
            ->groupBy('cars.brand')
            ->orderByDesc('count')
            ->value('brand');

        $topModel = DB::table('car_likes')
            ->join('cars', 'car_likes.car_id', '=', 'cars.id')
            ->where('car_likes.type', 1)
            ->selectRaw('cars.model, COUNT(*) as count')
            ->groupBy('cars.model')
            ->orderByDesc('count')
            ->value('model');

        $topType = DB::table('car_likes')
            ->join('cars', 'car_likes.car_id', '=', 'cars.id')
            ->where('car_likes.type', 1)
            ->selectRaw('cars.type, COUNT(*) as count')
            ->groupBy('cars.type')
            ->orderByDesc('count')
            ->value('type');

        $recentUsers = User::query()->where('is_admin', false)
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

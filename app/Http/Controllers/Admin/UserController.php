<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        $users = User::where('is_admin', false)
            ->withCount('carLikes')
            ->latest()
            ->get();

        return Inertia::render('admin/users/index', [
            'users' => $users,
        ]);
    }

    public function show(User $user): Response
    {
        $likedCars = $user->carLikes()
            ->with('car')
            ->latest()
            ->get()
            ->pluck('car');

        return Inertia::render('admin/users/show', [
            'user' => $user,
            'liked_cars' => $likedCars,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CarController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/cars/index', [
            'cars' => Car::withCount('likes')->latest()->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/cars/create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'in:Sedan,SUV,Hatchback,Truck,Coupe,Convertible,Crossover,Minivan'],
            'image' => ['required', 'image', 'max:4096'],
        ]);

        $path = $request->file('image')->store('cars', 'public');

        Car::create([
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'type' => $validated['type'],
            'image_url' => Storage::url($path),
        ]);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Car added to inventory.']);

        return to_route('admin.cars.index');
    }

    public function edit(Car $car): Response
    {
        return Inertia::render('admin/cars/edit', [
            'car' => $car,
        ]);
    }

    public function update(Request $request, Car $car): RedirectResponse
    {
        $validated = $request->validate([
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'in:Sedan,SUV,Hatchback,Truck,Coupe,Convertible,Crossover,Minivan'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $data = [
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'type' => $validated['type'],
        ];

        if ($request->hasFile('image')) {
            $this->deleteLocalImage($car->image_url);
            $data['image_url'] = Storage::url($request->file('image')->store('cars', 'public'));
        }

        $car->update($data);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Car updated.']);

        return to_route('admin.cars.index');
    }

    public function destroy(Car $car): RedirectResponse
    {
        $this->deleteLocalImage($car->image_url);
        $car->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Car removed from inventory.']);

        return to_route('admin.cars.index');
    }

    private function deleteLocalImage(string $imageUrl): void
    {
        if (str_starts_with($imageUrl, '/storage/')) {
            Storage::disk('public')->delete(substr($imageUrl, strlen('/storage/')));
        }
    }
}

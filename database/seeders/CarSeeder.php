<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            ['brand' => 'Toyota', 'model' => 'Camry', 'type' => 'Sedan', 'image_url' => 'https://placehold.co/400x300?text=Toyota+Camry'],
            ['brand' => 'Toyota', 'model' => 'Corolla', 'type' => 'Sedan', 'image_url' => 'https://placehold.co/400x300?text=Toyota+Corolla'],
            ['brand' => 'Toyota', 'model' => 'RAV4', 'type' => 'SUV', 'image_url' => 'https://placehold.co/400x300?text=Toyota+RAV4'],
            ['brand' => 'Toyota', 'model' => 'Hilux', 'type' => 'Truck', 'image_url' => 'https://placehold.co/400x300?text=Toyota+Hilux'],
            ['brand' => 'Toyota', 'model' => 'Yaris', 'type' => 'Hatchback', 'image_url' => 'https://placehold.co/400x300?text=Toyota+Yaris'],
            ['brand' => 'Honda', 'model' => 'Civic', 'type' => 'Sedan', 'image_url' => 'https://placehold.co/400x300?text=Honda+Civic'],
            ['brand' => 'Honda', 'model' => 'CR-V', 'type' => 'SUV', 'image_url' => 'https://placehold.co/400x300?text=Honda+CR-V'],
            ['brand' => 'Honda', 'model' => 'Accord', 'type' => 'Sedan', 'image_url' => 'https://placehold.co/400x300?text=Honda+Accord'],
            ['brand' => 'Honda', 'model' => 'Jazz', 'type' => 'Hatchback', 'image_url' => 'https://placehold.co/400x300?text=Honda+Jazz'],
            ['brand' => 'BMW', 'model' => '3 Series', 'type' => 'Sedan', 'image_url' => 'https://placehold.co/400x300?text=BMW+3+Series'],
            ['brand' => 'BMW', 'model' => 'X5', 'type' => 'SUV', 'image_url' => 'https://placehold.co/400x300?text=BMW+X5'],
            ['brand' => 'BMW', 'model' => 'M4', 'type' => 'Coupe', 'image_url' => 'https://placehold.co/400x300?text=BMW+M4'],
            ['brand' => 'BMW', 'model' => '5 Series', 'type' => 'Sedan', 'image_url' => 'https://placehold.co/400x300?text=BMW+5+Series'],
            ['brand' => 'Mercedes-Benz', 'model' => 'C-Class', 'type' => 'Sedan', 'image_url' => 'https://placehold.co/400x300?text=Mercedes+C-Class'],
            ['brand' => 'Mercedes-Benz', 'model' => 'GLE', 'type' => 'SUV', 'image_url' => 'https://placehold.co/400x300?text=Mercedes+GLE'],
            ['brand' => 'Mercedes-Benz', 'model' => 'A-Class', 'type' => 'Hatchback', 'image_url' => 'https://placehold.co/400x300?text=Mercedes+A-Class'],
            ['brand' => 'Mercedes-Benz', 'model' => 'SL-Class', 'type' => 'Convertible', 'image_url' => 'https://placehold.co/400x300?text=Mercedes+SL-Class'],
            ['brand' => 'Ford', 'model' => 'F-150', 'type' => 'Truck', 'image_url' => 'https://placehold.co/400x300?text=Ford+F-150'],
            ['brand' => 'Ford', 'model' => 'Mustang', 'type' => 'Coupe', 'image_url' => 'https://placehold.co/400x300?text=Ford+Mustang'],
            ['brand' => 'Ford', 'model' => 'Explorer', 'type' => 'SUV', 'image_url' => 'https://placehold.co/400x300?text=Ford+Explorer'],
            ['brand' => 'Ford', 'model' => 'Focus', 'type' => 'Hatchback', 'image_url' => 'https://placehold.co/400x300?text=Ford+Focus'],
            ['brand' => 'Chevrolet', 'model' => 'Silverado', 'type' => 'Truck', 'image_url' => 'https://placehold.co/400x300?text=Chevrolet+Silverado'],
            ['brand' => 'Chevrolet', 'model' => 'Camaro', 'type' => 'Coupe', 'image_url' => 'https://placehold.co/400x300?text=Chevrolet+Camaro'],
            ['brand' => 'Chevrolet', 'model' => 'Equinox', 'type' => 'Crossover', 'image_url' => 'https://placehold.co/400x300?text=Chevrolet+Equinox'],
            ['brand' => 'Audi', 'model' => 'A4', 'type' => 'Sedan', 'image_url' => 'https://placehold.co/400x300?text=Audi+A4'],
            ['brand' => 'Audi', 'model' => 'Q5', 'type' => 'SUV', 'image_url' => 'https://placehold.co/400x300?text=Audi+Q5'],
            ['brand' => 'Audi', 'model' => 'TT', 'type' => 'Coupe', 'image_url' => 'https://placehold.co/400x300?text=Audi+TT'],
            ['brand' => 'Nissan', 'model' => 'Altima', 'type' => 'Sedan', 'image_url' => 'https://placehold.co/400x300?text=Nissan+Altima'],
            ['brand' => 'Nissan', 'model' => 'X-Trail', 'type' => 'Crossover', 'image_url' => 'https://placehold.co/400x300?text=Nissan+X-Trail'],
            ['brand' => 'Nissan', 'model' => 'Navara', 'type' => 'Truck', 'image_url' => 'https://placehold.co/400x300?text=Nissan+Navara'],
            ['brand' => 'Hyundai', 'model' => 'Tucson', 'type' => 'SUV', 'image_url' => 'https://placehold.co/400x300?text=Hyundai+Tucson'],
            ['brand' => 'Hyundai', 'model' => 'Elantra', 'type' => 'Sedan', 'image_url' => 'https://placehold.co/400x300?text=Hyundai+Elantra'],
            ['brand' => 'Hyundai', 'model' => 'Staria', 'type' => 'Minivan', 'image_url' => 'https://placehold.co/400x300?text=Hyundai+Staria'],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}

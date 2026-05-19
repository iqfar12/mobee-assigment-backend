<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['brand', 'model', 'type', 'image_url'])]
class Car extends Model
{
    public function likes(): HasMany
    {
        return $this->hasMany(CarLike::class)->where('car_likes.type', 1);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(function (string $value): string {
            if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
                return $value;
            }

            return rtrim(config('app.url'), '/') . $value;
        });
    }
}

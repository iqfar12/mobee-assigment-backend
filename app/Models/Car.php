<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['brand', 'model', 'type', 'image_url'])]
class Car extends Model
{
    public function likes(): HasMany
    {
        return $this->hasMany(CarLike::class);
    }
}

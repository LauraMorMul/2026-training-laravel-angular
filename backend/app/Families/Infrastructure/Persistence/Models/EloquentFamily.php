<?php

namespace App\Families\Infrastructure\Persistence\Models;

use Database\Factories\RestaurantFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentFamily extends Model
{
    /** @use HasFactory<\Database\Factories\\Families\Infrastructure\Persistence\EloquentFamilyFactory> */
    use HasFactory;

    protected $table = 'families';

    protected static function newFactory(): Factory
    {
        return RestaurantFactory::new();
    }

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'name',
        'active',
    ];
}

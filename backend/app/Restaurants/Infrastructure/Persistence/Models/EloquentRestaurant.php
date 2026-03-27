<?php

namespace App\Restaurants\Infrastructure\Persistence\Models;

use Database\Factories\RestaurantFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentRestaurant extends Model
{
    /** @use HasFactory<\Database\Factories\\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurantFactory> */
    use HasFactory;

    protected $table = 'restaurants';

    protected static function newFactory(): Factory
    {
        return RestaurantFactory::new();
    }

    protected $fillable = [
        'uuid',
        'name',
        'legal_name',
        'tax_id',
        'email',
        'password'
    ];

    protected $hidden = [
        'password'
    ];
}

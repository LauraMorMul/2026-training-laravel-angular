<?php

namespace App\Products\Infrastructure\Persistence\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentProduct extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'family_id',
        'tax_id',
        'image_src',
        'name',
        'price',
        'stock',
        'active',
    ];
}

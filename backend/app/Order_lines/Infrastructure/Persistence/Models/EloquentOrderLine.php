<?php

namespace App\Order_lines\Infrastructure\Persistence\Models;

use Database\Factories\OrderLineFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EloquentOrderLine extends Model
{
    use HasFactory;

    protected $table = 'order_lines';

    protected static function newFactory(): Factory
    {
        return OrderLineFactory::new();
    }
    //

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'order_id',
        'product_id',
        'user_id',
        'quantity',
        'price',
        'tax_percentage',
    ];
}

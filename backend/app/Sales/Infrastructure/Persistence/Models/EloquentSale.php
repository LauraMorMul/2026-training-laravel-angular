<?php

namespace App\Sales\Infrastructure\Persistence\Models;

use Database\Factories\SaleFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EloquentSale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected static function newFactory(): Factory
    {
        return SaleFactory::new();
    }

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'order_id',
        'user_id',
        'ticket_number',
        'value_date',
        'total',
    ];
}

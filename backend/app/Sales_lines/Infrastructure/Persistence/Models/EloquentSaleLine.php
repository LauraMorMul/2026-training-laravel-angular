<?php

namespace App\Sales_lines\Infrastructure\Persistence\Models;

use Database\Factories\SaleLineFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EloquentSaleLine extends Model
{
    use HasFactory;

    protected $table = 'sales_lines';

    protected static function newFactory(): Factory
    {
        return SaleLineFactory::new();
    }

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'sale_id',
        'order_line_id',
        'user_id',
        'quantity',
        'price',
        'tax_percentage',
    ];
}

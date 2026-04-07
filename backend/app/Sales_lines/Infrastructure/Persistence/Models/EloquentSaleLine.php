<?php

namespace App\Sales_lines\Infrastructure\Persistence\Models;

use App\Order_lines\Infrastructure\Persistence\Models\EloquentOrderLine;
use App\Restaurants\Infrastructure\Persistence\Models\EloquentRestaurant;
use App\Sales\Infrastructure\Persistence\Models\EloquentSale;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Database\Factories\SaleLineFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(EloquentRestaurant::class, 'restaurant_id');
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(EloquentSale::class, 'sale_id');
    }

    public function orderLine(): BelongsTo
    {
        return $this->belongsTo(EloquentOrderLine::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'user_id');
    }
}

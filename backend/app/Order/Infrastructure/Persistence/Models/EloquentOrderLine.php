<?php

namespace App\Order_line\Infrastructure\Persistence\Models;

use App\Order\Infrastructure\Persistence\Models\EloquentOrder;
use App\Product\Infrastructure\Persistence\Models\EloquentProduct;
use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use App\Sales_line\Infrastructure\Persistence\Models\EloquentSaleLine;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Database\Factories\OrderLineFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentOrderLine extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function order(): BelongsTo
    {
        return $this->belongsTo(EloquentOrder::class, 'order_id');
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(EloquentRestaurant::class, 'restaurant_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(EloquentProduct::class, 'product_id');
    }

    public function saleLine(): HasOne
    {
        return $this->hasOne(EloquentSaleLine::class, 'order_line_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'user_id');
    }

    protected static function booted(): void
    {
        static::deleting(function (EloquentOrderLine $orderLine) {
            // Al eliminar una línea de pedido se debería actualizar la cantidad de stock de producto disponible
            $orderLine->product();
        });
    }
}

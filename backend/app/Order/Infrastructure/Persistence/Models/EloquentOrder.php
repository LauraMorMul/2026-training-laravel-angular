<?php

namespace App\Order\Infrastructure\Persistence\Models;

use App\Order_line\Infrastructure\Persistence\Models\EloquentOrderLine;
use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use App\Sale\Infrastructure\Persistence\Models\EloquentSale;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentOrder extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table ='orders';

    protected static function newFactory(): Factory
    {
        return OrderFactory::new();
    }

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'status',
        'table_id',
        'opened_by_user_id',
        'closed_by_user_id',
        'diners',
        'opened_at',
        'closed_at',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(EloquentRestaurant::class, 'restaurant_id');
    }

    public function orderLines(): HasMany
    {
        return $this->hasMany(EloquentOrderLine::class, 'order_id');
    }

    public function sale(): HasOne
    {
        return $this->hasOne(EloquentSale::class, 'order_id');
    }

    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'opened_by_user_id');
    }

    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'closed_by_user_id');
    }

    protected static function booted(): void
    {
        static::deleting(function (EloquentOrder $order) {
            $order->orderLines()->each(
                fn($orderLine) => $orderLine->delete()
            );
        });
    }
}

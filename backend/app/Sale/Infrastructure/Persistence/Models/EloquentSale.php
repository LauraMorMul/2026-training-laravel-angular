<?php

namespace App\Sale\Infrastructure\Persistence\Models;

use App\Order\Infrastructure\Persistence\Models\EloquentOrder;
use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use App\Sales_line\Infrastructure\Persistence\Models\EloquentSaleLine;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Database\Factories\SaleFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentSale extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function salesLines(): HasMany
    {
        return $this->hasMany(EloquentSaleLine::class, 'sale_id');
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(EloquentRestaurant::class, 'restaurant_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(EloquentOrder::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'user_id');
    }
}

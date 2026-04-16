<?php

namespace App\Restaurant\Infrastructure\Persistence\Models;

use App\Family\Infrastructure\Persistence\Models\EloquentFamily;
use App\Order_line\Infrastructure\Persistence\Models\EloquentOrderLine;
use App\Order\Infrastructure\Persistence\Models\EloquentOrder;
use App\Product\Infrastructure\Persistence\Models\EloquentProduct;
use App\Sales\Infrastructure\Persistence\Models\EloquentSale;
use App\Sales_lines\Infrastructure\Persistence\Models\EloquentSaleLine;
use App\Tables\Infrastructure\Persistence\Models\EloquentTable;
use App\Taxes\Infrastructure\Persistence\Models\EloquentTax;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use App\Zones\Infrastructure\Persistence\Models\EloquentZone;
use Database\Factories\RestaurantFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentRestaurant extends Model
{
    /** @use HasFactory<\Database\Factories\\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurantFactory> */
    use HasFactory;
    use SoftDeletes;

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

    public function users(): HasMany
    {
        return $this->hasMany(EloquentUser::class, 'restaurant_id');
    }

    public function families(): HasMany
    {
        return $this->hasMany(EloquentFamily::class, 'restaurant_id');
    }

    public function taxes(): HasMany
    {
        return $this->hasMany(EloquentTax::class, 'restaurant_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(EloquentProduct::class, 'restaurant_id');
    }

    public function zones(): HasMany
    {
        return $this->hasMany(EloquentZone::class, 'restaurant_id');
    }

    public function tables(): HasMany
    {
        return $this->hasMany(EloquentTable::class, 'restaurant_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(EloquentOrder::class, 'restaurant_id');
    }

    public function orderLines(): HasMany
    {
        return $this->hasMany(EloquentOrderLine::class, 'restaurant_id');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(EloquentSale::class, 'restaurant_id');
    }

    public function salesLines(): HasMany
    {
        return $this->hasMany(EloquentSaleLine::class, 'restaurant_id');
    }

    protected static function booted(): void
    {
        static::deleting(function (EloquentRestaurant $restaurant) {
            $restaurant->users()->each(
                fn($user) => $user->delete()
            );

            $restaurant->families()->each(
                fn($family) => $family->delete()
            );

            $restaurant->taxes()->each(
                fn($tax) => $tax->delete()
            );

            $restaurant->products()->each(
                fn($product) => $product->delete()
            );

            $restaurant->zones()->each(
                fn($zone) => $zone->delete()
            );

            $restaurant->tables()->each(
                fn($table) => $table->delete()
            );

            $restaurant->orders()->each(
                fn($order) => $order->delete()
            );

            $restaurant->orderLines()->each(
                fn($orderLine) => $orderLine->delete()
            );

            $restaurant->sales()->each(
                fn($sale) => $sale->delete()
            );

            $restaurant->salesLines()->each(
                fn($saleLine) => $saleLine->delete()
            );
        });
    }
}

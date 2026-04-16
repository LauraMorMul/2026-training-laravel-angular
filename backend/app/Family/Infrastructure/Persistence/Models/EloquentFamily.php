<?php

namespace App\Family\Infrastructure\Persistence\Models;

use App\Products\Infrastructure\Persistence\Models\EloquentProduct;
use App\Restaurants\Infrastructure\Persistence\Models\EloquentRestaurant;
use Database\Factories\FamilyFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentFamily extends Model
{
    /** @use HasFactory<\Database\Factories\\Families\Infrastructure\Persistence\EloquentFamilyFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'families';

    protected static function newFactory(): Factory
    {
        return FamilyFactory::new();
    }

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'name',
        'active',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(EloquentRestaurant::class, 'restaurant_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(EloquentProduct::class, 'family_id');
    }

    protected static function booted(): void
    {
        static::deleting(function (EloquentFamily $family) {
            $family->products()->each(
                fn($product) => $product->delete()
            );
        });
    }
}

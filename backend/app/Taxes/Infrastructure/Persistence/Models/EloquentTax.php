<?php

namespace App\Taxes\Infrastructure\Persistence\Models;

use App\Products\Infrastructure\Persistence\Models\EloquentProduct;
use App\Restaurants\Infrastructure\Persistence\Models\EloquentRestaurant;
use Database\Factories\TaxFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentTax extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'taxes';

    protected static function newFactory(): Factory
    {
        return TaxFactory::new();
    }

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'name',
        'percentage',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(EloquentProduct::class, 'tax_id');
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(EloquentRestaurant::class, 'restaurant_id');
    }
}

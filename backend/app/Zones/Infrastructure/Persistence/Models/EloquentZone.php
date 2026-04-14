<?php

namespace App\Zones\Infrastructure\Persistence\Models;

use App\Restaurants\Infrastructure\Persistence\Models\EloquentRestaurant;
use App\Tables\Infrastructure\Persistence\Models\EloquentTable;
use Database\Factories\ZoneFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentZone extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'zones';

    protected static function newFactory(): Factory
    {
        return ZoneFactory::new();
    }

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'name',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(EloquentRestaurant::class, 'restaurant_id');
    }

    public function tables(): HasMany
    {
        return $this->hasMany(EloquentTable::class, 'zone_id');
    }

    protected static function booted(): void
    {
        static::deleting(function (EloquentZone $zone) {
            $zone->tables()->each(
                fn($table) => $table->delete()
            );
        });
    }
}

<?php

namespace App\Zones\Infrastructure\Persistence\Models;

use Database\Factories\ZoneFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EloquentZone extends Model
{
    use HasFactory;

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
}

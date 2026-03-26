<?php

namespace App\Tables\Infrastructure\Persistence\Models;

use Database\Factories\TableFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EloquentTable extends Model
{
    use HasFactory;

    protected $table = 'tables';

    protected static function newFactory(): Factory
    {
        return TableFactory::new();
    }

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'zone_id',
        'name',
    ];
}

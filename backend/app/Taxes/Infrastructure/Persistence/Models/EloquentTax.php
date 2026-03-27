<?php

namespace App\Taxes\Infrastructure\Persistence\Models;

use Database\Factories\TaxFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentTax extends Model
{
    use HasFactory;

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
}

<?php

namespace App\Orders\Infrastructure\Persistence\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentOrder extends Model
{
    use HasFactory;
    
    protected $table ='orders';

    protected static function newFactory(): Factory
    {
        return OrderFactory::new();
    }

    protected $fillable = [
        'uuid',
        'resturant_id',
        'status',
        'table_id',
        'opened_by_user_id',
        'closed_by_user_id',
        'dinners',
        'opened_at',
        'closed_at',
    ];
}

<?php

namespace App\User\Infrastructure\Persistence\Models;

use App\Order_line\Infrastructure\Persistence\Models\EloquentOrderLine;
use App\Sales_line\Infrastructure\Persistence\Models\EloquentSaleLine;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class EloquentUser extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $table = 'users';

    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'role',
        'image_src',
        'name',
        'email',
        'password',
        'pin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function getKeyName(): string
    {
        return 'id';
    }

    public function orderLines(): HasMany
    {
        return $this->hasMany(EloquentOrderLine::class, 'user_id');
    }

    public function salesLines(): HasMany
    {
        return $this->hasMany(EloquentSaleLine::class, 'user_id');
    }
}

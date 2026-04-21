<?php

namespace App\Restaurant\Infrastructure\Services;

use App\Restaurant\Domain\Entity\Restaurant;
use App\Restaurant\Domain\Interfaces\TokenManagerInterface;
use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class SanctumTokenManager implements TokenManagerInterface
{
    public function issueToken(Restaurant $restaurant): string
    {
        $eloquentRestaurant = EloquentRestaurant::where('uuid', $restaurant->id()->value())->first();

        if ($eloquentRestaurant === null) {
            throw new NotFoundResourceException('Usuario no encontrado');
        }

        $token = $eloquentRestaurant->createToken('Login token');

        return $token->plainTextToken;
    }

    public function removeTokens(Restaurant $restaurant): void
    {
        $eloquentRestaurant = EloquentRestaurant::where('uuid', $restaurant->id()->value())->first();

        if ($eloquentRestaurant === null) {
            throw new NotFoundResourceException('Usuario no encontrado');
        }

        $eloquentRestaurant->tokens()->delete();
    }
}

<?php

namespace App\User\Infrastructure\Persistence\Repositories;

use App\User\Domain\Entity\User;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Infrastructure\Persistence\Models\EloquentUser;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private EloquentUser $model,
    ) {}

    public function save(User $user): void
    {
        $this->model->newQuery()->updateOrCreate(
            ['uuid' => $user->id()->value()],
            [
                'restaurant_id' => $user->restaurantID()->value(),
                'role' => $user->role()->value(),
                'image_src' => $user->imageSrc()->value(),
                'name' => $user->name()->value(),
                'email' => $user->email()->value(),
                'password' => $user->passwordHash()->value(),
                'pin' => $user->pin()->value(),
                'created_at' => $user->createdAt()->value(),
                'updated_at' => $user->updatedAt()->value(),
            ]
        );
    }

    public function findById(string $id): ?User
    {
        $model = $this->model->newQuery()->where('uuid', $id)->first();

        if ($model === null) {
            return null;
        }

        return User::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->role,
            $model->image_src,
            $model->name,
            $model->email,
            $model->password,
            $model->pin,
            $model->created_at->toDateTimeImmutable(),
            $model->updated_at->toDateTimeImmutable(),
        );
    }

    public function getAll(): ?array
    {
        $models = $this->model->newQuery()->getModels();
        $users = array();

        if ($models === null) {
            return null;
        }

        foreach($models as $model) {
            $user = User::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->role,
            $model->image_src,
            $model->name,
            $model->email,
            $model->password,
            $model->pin,
            $model->created_at->toDateTimeImmutable(),
            $model->updated_at->toDateTimeImmutable(),
        );
            array_push($users, $user);
        }

        return $users;
    }

    public function getByRestaurant(string $restaurantID): ?array
    {
        $models = $this->model->newQuery()->whereIn('restaurant_id', function($query) use ($restaurantID) {
            $query->select('id')
            ->from('restaurants')
            ->where('uuid', $restaurantID);
        })->getModels();
        $users = array();

        if ($models === null) {
            return null;
        }

        foreach($models as $model) {
            $user = User::fromPersistence(
            $model->uuid,
            $model->restaurant_id,
            $model->role,
            $model->image_src,
            $model->name,
            $model->email,
            $model->password,
            $model->pin,
            $model->created_at->toDateTimeImmutable(),
            $model->updated_at->toDateTimeImmutable(),
        );
            array_push($users, $user);
        }

        return $users;
    }

    public function deleteByID(string $id): void
    {
        $this->model->newQuery()->where('uuid', $id)->delete();
    }
}

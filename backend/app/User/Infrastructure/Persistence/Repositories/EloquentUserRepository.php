<?php

namespace App\User\Infrastructure\Persistence\Repositories;

use App\User\Domain\Entity\User;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

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
                'restaurant_id' => $user->restaurantID(),
                'role' => $user->role(),
                'image_src' => $user->imageSrc(),
                'name' => $user->name(),
                'email' => $user->email()->value(),
                'password' => $user->passwordHash(),
                'pin' => $user->pin(),
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
        $models = $this->model->newQuery()->where('restaurant_id', $restaurantID)->getModels();
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

    public function deleteByID(string $id): ?string
    {
        $this->model->newQuery()->where('uuid', $id)->delete();

        $response = $this->model->newQuery()->where('uuid', $id)->get('deleted_at');

        return $response;
    }
}

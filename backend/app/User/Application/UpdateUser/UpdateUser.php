<?php

namespace App\User\Application\UpdateUser;

use App\Shared\Domain\Interfaces\PasswordHasherInterface;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\ImageSrc;
use App\Shared\Domain\ValueObject\PasswordHash;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Domain\ValueObject\Pin;
use App\User\Domain\ValueObject\Role;
use App\User\Domain\ValueObject\UserName;

class UpdateUser
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHasherInterface $passwordHasher
    ) {}

    public function __invoke(string $uuid, ?string $email, ?string $name, ?string $plainPassword, ?string $role, ?string $imageSrc, ?string $pin, int $restaurantID): ?UpdateUserResponse
    {
        $user = $this->userRepository->findById($uuid);

        if ($user === null || $user->restaurantID()->value() !== $restaurantID) {
            return null;
        }

        if ($user === null) {
            return null;
        }

        if ($email === null) {
            $emailVO = $user->email();
        } else {
            $emailVO = Email::create($email);
        }

        if ($name === null) {
            $nameVO = $user->name();
        } else {
            $nameVO = UserName::create($name);
        }

        if ($plainPassword === null) {
            $passwordHashVO = $user->passwordHash();
        } else {
            $passwordHashVO = PasswordHash::create($this->passwordHasher->hash($plainPassword));
        }

        if ($role === null) {
            $roleVO = $user->role();
        } else {
            $roleVO = Role::create($role);
        }

        if ($imageSrc === null) {
            $imageSrcVO = $user->imageSrc();
        } else {
            $imageSrcVO = ImageSrc::create($imageSrc);
        }

        if ($pin === null) {
            $pinVO = $user->pin();
        } else {
            $pinVO = Pin::create($pin);
        }

        $user = $user->updateData($emailVO, $nameVO, $passwordHashVO, $roleVO, $imageSrcVO, $pinVO);
        $this->userRepository->save($user);

        return UpdateUserResponse::create($user);
    }
}

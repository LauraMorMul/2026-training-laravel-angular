<?php

namespace App\User\Application\CreateUser;

use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\ImageSrc;
use App\User\Domain\Entity\User;
use App\User\Domain\Interfaces\PasswordHasherInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\Shared\Domain\ValueObject\PasswordHash;
use App\User\Domain\ValueObject\Pin;
use App\User\Domain\ValueObject\Role;
use App\User\Domain\ValueObject\UserName;

class CreateUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHasherInterface $passwordHasher,
    ) {}

    public function __invoke(string $email, string $name, string $plainPassword, string $role, string $imageSrc, string $pin): CreateUserResponse
    {
        $emailVO = Email::create($email);
        $nameVO = UserName::create($name);
        $passwordHashVO = PasswordHash::create($this->passwordHasher->hash($plainPassword));
        $roleVO = Role::create($role);
        $imageSrcVO = ImageSrc::create($imageSrc);
        $pinVO = Pin::create($pin);
        $user = User::dddCreate($emailVO, $nameVO, $passwordHashVO, $roleVO, $imageSrcVO, $pinVO);
        $this->userRepository->save($user);

        return CreateUserResponse::create($user);
    }
}

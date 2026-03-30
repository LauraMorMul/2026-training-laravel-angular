<?php

namespace App\User\Domain\Entity;

use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\ImageSrc;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Domain\ValueObject\PasswordHash;
use App\User\Domain\ValueObject\Pin;
use App\User\Domain\ValueObject\Role;
use App\User\Domain\ValueObject\UserName;

class User
{
    private function __construct(
        private Uuid $id,
        private Role $role,
        private ImageSrc $imageSrc,
        private UserName $name,
        private Email $email,
        private PasswordHash $passwordHash,
        private Pin $pin,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    ) {}

    public static function  dddCreate(Email $email, UserName $name, PasswordHash $passwordHash, Role $role, ImageSrc $imageSrc, Pin $pin): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $role,
            $imageSrc,
            $name,
            $email,
            $passwordHash,
            $pin,
            $now,
            $now,
        );
    }

    public static function fromPersistence(
        string $id,
        string $role,
        string $imageSrc,
        string $name,
        string $email,
        string $passwordHash,
        string $pin,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            Uuid::create($id),
            Role::create($role),
            ImageSrc::create($imageSrc),
            UserName::create($name),
            Email::create($email),
            PasswordHash::create($passwordHash),
            Pin::create($pin),
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt),
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function role(): string
    {
        return $this->role->value();
    }

    public function imageSrc(): string
    {
        return $this->imageSrc->value();
    }

    public function name(): string
    {
        return $this->name->value();
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function passwordHash(): string
    {
        return $this->passwordHash->value();
    }

    public function pin(): string
    {
        return $this->pin->value();
    }

    public function createdAt(): DomainDateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): DomainDateTime
    {
        return $this->updatedAt;
    }
}

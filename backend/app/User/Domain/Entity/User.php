<?php

namespace App\User\Domain\Entity;

use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\ImageSrc;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Domain\ValueObject\PasswordHash;
use App\Shared\Domain\ValueObject\RestaurantID;
use App\User\Domain\ValueObject\Pin;
use App\User\Domain\ValueObject\Role;
use App\User\Domain\ValueObject\UserName;

class User
{
    private function __construct(
        private Uuid $id,
        private RestaurantID $restaurantID,
        private Role $role,
        private ImageSrc $imageSrc,
        private UserName $name,
        private Email $email,
        private PasswordHash $passwordHash,
        private Pin $pin,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    ) {}

    public static function  dddCreate(Email $email, UserName $name, PasswordHash $passwordHash, RestaurantID $restaurantID, Role $role, ImageSrc $imageSrc, Pin $pin): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $restaurantID,
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
        string $restaurantID,
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
            RestaurantID::create($restaurantID),
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

    public function updateData(
        Email $email,
        UserName $name,
        PasswordHash $password,
        Role $role,
        ImageSrc $imageSrc,
        Pin $pin,
    ): self
    {
        return new self(
            $this->id,
            $this->restaurantID,
            $role,
            $imageSrc,
            $name,
            $email,
            $password,
            $pin,
            $this->createdAt,
            DomainDateTime::now(),
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function restaurantID(): RestaurantID
    {
        return $this->restaurantID;
    }

    public function role(): Role
    {
        return $this->role;
    }

    public function imageSrc(): ImageSrc
    {
        return $this->imageSrc;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function passwordHash(): PasswordHash
    {
        return $this->passwordHash;
    }

    public function pin(): Pin
    {
        return $this->pin;
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

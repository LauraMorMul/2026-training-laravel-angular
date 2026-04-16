<?php

namespace App\Restaurant\Domain\Entity;

use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Restaurant\Domain\ValueObject\LegalName;
use App\Restaurant\Domain\ValueObject\TaxID;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\PasswordHash;
use App\Shared\Domain\ValueObject\Uuid;

class Restaurant
{
    private function __construct(
        private Uuid $id,
        private Name $name,
        private LegalName $legalName,
        private TaxID $taxID,
        private Email $email,
        private PasswordHash $passwordHash,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    )
    {}

    public static function dddCreate(Name $name, LegalName $legalName, TaxID $taxID, Email $email, PasswordHash $passwordHash): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $name,
            $legalName,
            $taxID,
            $email,
            $passwordHash,
            $now,
            $now,
        );
    }

    public static function fromPersistence(
        string $id,
        string $name,
        string $legalName,
        string $taxID,
        string $email,
        string $passwordHash,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            Uuid::create($id),
            Name::create($name),
            LegalName::create($legalName),
            TaxID::create($taxID),
            Email::create($email),
            PasswordHash::create($passwordHash),
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt),
        );
    }

    public function updateData(
        Name $name,
        LegalName $legalName,
        TaxID $taxID,
        Email $email,
        PasswordHash $passwordHash,
    ): self
    {
        return new self(
            $this->id,
            $name,
            $legalName,
            $taxID,
            $email,
            $passwordHash,
            $this->createdAt,
            DomainDateTime::now(),
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function legalName(): LegalName
    {
        return $this->legalName;
    }

    public function taxID(): TaxID
    {
        return $this->taxID;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function passwordHash(): PasswordHash
    {
        return $this->passwordHash;
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
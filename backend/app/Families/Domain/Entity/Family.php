<?

namespace App\User\Domain\Entity;

use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\ValueObject\Name;

class Family
{
    private function __construct(
        private Uuid $id,
        private Name $name,
        private bool $active,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    ) {}

    public static function dddCreate(Name $name, bool $active): self
    {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $name,
            $active,
            $now,
            $now,
        );
    }

    public static function fromPersistence(
        string $id,
        string $name,
        bool $active,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
        \DateTimeImmutable $deletedAt,
    ): self {
        return new self(
            Uuid::create($id),
            Name::create($name),
            boolval($active),
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt),
            DomainDateTime::create($deletedAt),
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

    public function active(): bool
    {
        return $this->active;
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
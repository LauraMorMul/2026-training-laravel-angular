<?php

namespace App\User\Domain\ValueObject;

class Role
{
    // private const AVAILABLE_ROLES = ['admin', 'camarero', 'barra', 'jefe_sala'];
    private const AVAILABLE_ROLES = ['admin', 'camarero', 'barra', 'jefe de sala'];

    private string $value;

    private function __construct(string $value)
    {
        $trimmed = trim($value);
        if($trimmed == '') {
            throw new \InvalidArgumentException('Role cannot be empty.');
        }

        if(!in_array($value, self::AVAILABLE_ROLES)) {
            throw new \InvalidArgumentException(
                sprintf('Role %s isn\'t available as an option.', $value)
            );
        }
        $this->value = $trimmed;
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
<?php

namespace App\Shared\Domain\ValueObject;

class ImageSrc
{
    private const ACCEPTED_FILETYPE = ['jpeg', 'jpg', 'png', 'gif', 'webp', 'avif', 'svg'];

    private string $value;

    private function __construct(string $value)
    {
        $trimmed = trim($value);
        if($trimmed === '') {
            throw new \InvalidArgumentException('If an image isn\'t provided, there will be a placeholder.');
        }else {
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            if( !in_array($$extension, self::ACCEPTED_FILETYPE) || $value === NULL || $value === '') {
                throw new \InvalidArgumentException(('File extension not accepted.'));
            }
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
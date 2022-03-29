<?php

declare(strict_types=1);

namespace App\DoTheSums\Shared\Domain\ValueObject;

final class NotEmptyName
{
    private string $value;

    private function __construct(string $amount)
    {
        $this->value = $amount;
    }

    public static function fromString(string $name): self
    {
        if (\strlen($name) < 3) {
            throw new \InvalidArgumentException('A name must contain at least 3 characters');
        }

        return new self($name);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(self $emptyName): bool
    {
        return $this->value === $emptyName->getValue();
    }
}

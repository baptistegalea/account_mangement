<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Domain\ValueObject;

final class OneTimePassword
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public static function create(): self
    {
        return new self((string) \random_int(100000, 999999));
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $oneTimePassword): bool
    {
        return $this->value === $oneTimePassword->value();
    }
}

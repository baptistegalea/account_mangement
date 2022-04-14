<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Domain\ValueObject;

final class Email
{
    private string $value;

    private function __construct(string $email)
    {
        $this->value = $email;
    }

    public static function fromString(string $email): self
    {
        if (\filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException('This value is not a valid email');
        }
        return new self($email);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

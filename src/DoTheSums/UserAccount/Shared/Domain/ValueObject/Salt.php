<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Domain\ValueObject;

final class Salt
{
    private string $value;

    private function __construct(string $salt)
    {
        $this->value = $salt;
    }

    public static function fromString(string $salt): self
    {
        return new self($salt);
    }

    public static function generate(): self
    {
        $salt = \rtrim(\str_replace('+', '.', \base64_encode(\random_bytes(32))), '=');
        return new self($salt);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Domain\ValueObject;

final class Password
{
    private string $value;

    private function __construct(string $password)
    {
        $this->value = $password;
    }

    public static function fromString(string $password): self
    {
        if (\preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[$@;,.!?=()\-_'])\S{7,30}$/", $password) !== 1) {
            throw new \InvalidArgumentException(
                'This password does not fulfill securty requirements.
                A least 1 letter lower case.
                At least 1 letter upper case.
                At least 1 special character.
                At least 1 number.
                At least 7 characters with a maximum of 30.'
            );
        }

        return new self($password);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

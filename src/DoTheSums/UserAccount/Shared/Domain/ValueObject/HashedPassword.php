<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Domain\ValueObject;

final class HashedPassword
{
    private string $value;
    private Salt $salt;

    private function __construct(string $password, Salt $salt)
    {
        $this->value = $password;
        $this->salt = $salt;
    }

    public static function create(string $password, Salt $salt, string $secret): self
    {
        $saltedPwd = $salt->getValue().$password;

        return new self(\hash_hmac('sha256', $saltedPwd, $secret), $salt);
    }

    public function getHashedPassword(): string
    {
        return $this->value;
    }

    public function equals(string $hashedPwd): bool
    {
        return $hashedPwd === $this->value;
    }

    public function getSalt(): Salt
    {
        return $this->salt;
    }
}

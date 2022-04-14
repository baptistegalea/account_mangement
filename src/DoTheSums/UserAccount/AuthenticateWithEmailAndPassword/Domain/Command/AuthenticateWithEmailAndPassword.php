<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\AuthenticateWithEmailAndPassword\Domain\Command;

use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Email;

final class AuthenticateWithEmailAndPassword
{
    private Email $email;
    // password here is not a value object because we don't want to check password validity
    private string $password;

    public function __construct(Email $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

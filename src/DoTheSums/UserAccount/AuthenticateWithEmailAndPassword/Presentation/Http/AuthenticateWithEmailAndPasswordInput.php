<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\AuthenticateWithEmailAndPassword\Presentation\Http;

final class AuthenticateWithEmailAndPasswordInput
{
    public string $email;
    public string $password;
}

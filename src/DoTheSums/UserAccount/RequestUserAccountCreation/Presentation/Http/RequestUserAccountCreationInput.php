<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\RequestUserAccountCreation\Presentation\Http;

final class RequestUserAccountCreationInput
{
    public string $email;
    public string $name;
    public string $password;
}

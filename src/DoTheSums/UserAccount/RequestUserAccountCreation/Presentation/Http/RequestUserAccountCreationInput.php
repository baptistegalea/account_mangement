<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\RequestUserAccountCreation\Presentation\Http;

final class RequestUserAccountCreationInput
{
    private string $email;
    private string $name;
    private string $password;

    public function __construct(string $email, string $name, string $password)
    {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

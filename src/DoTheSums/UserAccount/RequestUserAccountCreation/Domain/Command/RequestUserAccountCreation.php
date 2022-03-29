<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\RequestUserAccountCreation\Domain\Command;

use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Email;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Password;

final class RequestUserAccountCreation
{
    private Email $email;
    private NotEmptyName $name;
    private Password $password;
    private \DateTimeImmutable $requestedAt;

    public function __construct(Email $email, NotEmptyName $name, Password $password, \DateTimeImmutable $requestedAt)
    {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->requestedAt = $requestedAt;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getName(): NotEmptyName
    {
        return $this->name;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getRequestedAt(): \DateTimeImmutable
    {
        return $this->requestedAt;
    }
}

<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\ValidateUserAccountCreation\Domain\Command;

use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\OneTimePassword;
use Symfony\Component\Uid\Ulid;

final class ValidateUserAccountCreation
{
    private Ulid $userAccountCreationRequestUlid;
    private OneTimePassword $oneTimePassword;

    public function __construct(Ulid $requestedUserCreationUlid, OneTimePassword $oneTimePassword)
    {
        $this->userAccountCreationRequestUlid = $requestedUserCreationUlid;
        $this->oneTimePassword = $oneTimePassword;
    }

    public function getUserAccountCreationRequestUlid(): Ulid
    {
        return $this->userAccountCreationRequestUlid;
    }

    public function getOneTimePassword(): OneTimePassword
    {
        return $this->oneTimePassword;
    }
}

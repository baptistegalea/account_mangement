<?php

declare(strict_types=1);

namespace App\DoTheSums\Shared\Infrastructure\Symfony\Security\Http\Authenticator;

use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccount;
use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface
{
    private UserAccount $userAccount;

    public function __construct(UserAccount $userAccount)
    {
        $this->userAccount = $userAccount;
    }

    public function getUserAccount(): UserAccount
    {
        return $this->userAccount;
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    public function eraseCredentials()
    {
        // do nothing
    }

    public function getUserIdentifier(): string
    {
        return 'email';
    }
}

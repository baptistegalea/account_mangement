<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Infrastructure\Symfony\Security;

use App\DoTheSums\Shared\Infrastructure\Symfony\Security\Http\Authenticator\User;
use App\DoTheSums\Shared\Domain\Entity\UserAccount;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class AuthUserAccountStorage
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getAuthenticatedUserAccount(): UserAccount
    {
        if ($this->tokenStorage->getToken() === null) {
            throw new \Exception('There is no token in the token storage');
        }
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user instanceof User === false) {
            throw new \Exception('The authenticated user is not the right implementation of UserInterface');
        }

        return $user->getUserAccount();
    }
}

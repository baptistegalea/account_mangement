<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\AuthenticateWithEmailAndPassword\Domain\Command;

use App\DoTheSums\UserAccount\AuthenticateWithEmailAndPassword\Domain\Service\JWTIssuer;
use App\DoTheSums\Shared\Domain\Entity\UserAccount;
use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountRepository;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\HashedPassword;

final class AuthenticateWithEmailAndPasswordHandler
{
    private UserAccountRepository $userAccountRepository;
    private JWTIssuer $JWTIssuer;

    public function __construct(UserAccountRepository $userAccountRepository, JWTIssuer $JWTIssuer)
    {
        $this->userAccountRepository = $userAccountRepository;
        $this->JWTIssuer = $JWTIssuer;
    }

    public function handle(AuthenticateWithEmailAndPassword $command): string
    {
        $user = $this->userAccountRepository->findByEmail($command->getEmail());

        if ($user instanceof UserAccount === false) {
            throw new \Exception('This user does not exist');
        }

        $requestedPasswordHashed = HashedPassword::create(
            $command->getPassword(),
            $user->getSalt(),
            'MySuperSecretToChange!!'
        );

        if ($requestedPasswordHashed->equals($user->getHashedPassword()) === false) {
            throw new \Exception('Password does not match');
        }

        return $this->JWTIssuer->issueJWT($user);
    }
}

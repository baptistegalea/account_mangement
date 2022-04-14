<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\ValidateUserAccountCreation\Domain\Command;

use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccount;
use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountCreationRequestRepository;
use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountRepository;

final class ValidateUserAccountCreationHandler
{
    private UserAccountCreationRequestRepository $userAccountCreationRequestRepository;
    private UserAccountRepository $userAccountRepository;

    public function __construct(UserAccountCreationRequestRepository $userAccountCreationRequestRepository, UserAccountRepository $userAccountRepository)
    {
        $this->userAccountCreationRequestRepository = $userAccountCreationRequestRepository;
        $this->userAccountRepository = $userAccountRepository;
    }

    public function handle(ValidateUserAccountCreation $command): void
    {
        $userAccountCreationRequest = $this->userAccountCreationRequestRepository->getByUlid($command->getUserAccountCreationRequestUlid());

        if ($userAccountCreationRequest->getOneTimePassword()->equals($command->getOneTimePassword()) === false) {
            throw new \InvalidArgumentException('The provided OTP does not match');
        }

        $userAccount = UserAccount::fromUserAccountCreationRequest($userAccountCreationRequest, new \DateTimeImmutable());

        $this->userAccountRepository->save($userAccount);
    }
}

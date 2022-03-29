<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\ValidateUserAccountCreation\Domain\Command;

use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccount;
use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountCreationRequestRepositoryInterface;
use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountRepositoryInterface;

final class ValidateUserAccountCreationHandler
{
    private UserAccountCreationRequestRepositoryInterface $userAccountCreationRequestRepository;
    private UserAccountRepositoryInterface $userAccountRepository;

    public function __construct(UserAccountCreationRequestRepositoryInterface $userAccountCreationRequestRepository, UserAccountRepositoryInterface $userAccountRepository)
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

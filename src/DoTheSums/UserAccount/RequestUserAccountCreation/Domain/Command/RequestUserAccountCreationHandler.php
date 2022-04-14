<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\RequestUserAccountCreation\Domain\Command;

use App\DoTheSums\UserAccount\RequestUserAccountCreation\Domain\Output\RequestUserAccountCreationOutput;
use App\DoTheSums\Shared\Domain\Entity\UserAccount;
use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccountCreationRequest;
use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountRepository;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\HashedPassword;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\OneTimePassword;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Salt;
use App\DoTheSums\UserAccount\Shared\Infrastructure\Repository\UserAccountCreationRequestRepository;

final class RequestUserAccountCreationHandler
{
    private UserAccountCreationRequestRepository $userAccountCreationRequestRepository;
    private UserAccountRepository $userAccountRepository;

    public function __construct(UserAccountCreationRequestRepository $userAccountCreationRequestRepository, UserAccountRepository $userAccountRepository)
    {
        $this->userAccountCreationRequestRepository = $userAccountCreationRequestRepository;
        $this->userAccountRepository = $userAccountRepository;
    }

    public function handle(RequestUserAccountCreation $requestUserAccountCreation): RequestUserAccountCreationOutput
    {
        $userAccount = $this->userAccountRepository->findByEmail($requestUserAccountCreation->getEmail());

        if ($userAccount instanceof UserAccount) {
            throw new \Exception('A user with this mail already exist');
        }

        $salt = Salt::generate();

        $hashedPassword = HashedPassword::create(
            $requestUserAccountCreation->getPassword()->getValue(),
            $salt,
            'MySuperSecretToChange!!'
        );

        $userAccountCreationRequest = new UserAccountCreationRequest(
            $requestUserAccountCreation->getEmail(),
            $hashedPassword,
            $requestUserAccountCreation->getName(),
            OneTimePassword::create(),
            $requestUserAccountCreation->getRequestedAt()
        );

        $this->userAccountCreationRequestRepository->save($userAccountCreationRequest);

//        $this->emailService->send($email);

        return new RequestUserAccountCreationOutput($userAccountCreationRequest->getUlid()->toRfc4122());
    }
}

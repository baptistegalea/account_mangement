<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\RequestUserAccountCreation\Domain\Command;

use App\DoTheSums\UserAccount\RequestUserAccountCreation\Domain\Output\RequestUserAccountCreationOutput;
use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccount;
use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccountCreationRequest;
use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountRepositoryInterface;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\OneTimePassword;
use App\DoTheSums\UserAccount\Shared\Infrastructure\Repository\UserAccountCreationRequestRepository;

final class RequestUserAccountCreationHandler
{
    private UserAccountCreationRequestRepository $userAccountCreationRequestRepository;
    private UserAccountRepositoryInterface $userAccountRepository;

    public function __construct(UserAccountCreationRequestRepository $userAccountCreationRequestRepository, UserAccountRepositoryInterface $userAccountRepository)
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

        $userAccountCreationRequest = new UserAccountCreationRequest(
            $requestUserAccountCreation->getEmail(),
            $requestUserAccountCreation->getPassword()->getHashedValue(),
            $requestUserAccountCreation->getName(),
            OneTimePassword::create(),
            $requestUserAccountCreation->getRequestedAt()
        );

        $this->userAccountCreationRequestRepository->save($userAccountCreationRequest);

//        $this->emailService->send($email);

        $output = new RequestUserAccountCreationOutput();
        $output->ulid = $userAccountCreationRequest->getUlid()->toRfc4122();
        return $output;
    }
}

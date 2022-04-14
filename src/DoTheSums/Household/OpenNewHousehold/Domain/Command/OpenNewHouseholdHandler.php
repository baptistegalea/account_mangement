<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\OpenNewHousehold\Domain\Command;

use App\DoTheSums\Household\Shared\Domain\Repository\HouseholdRepository;
use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountRepository;

final class OpenNewHouseholdHandler
{
    private UserAccountRepository $userAccountRepository;

    public function __construct(UserAccountRepository $userAccountRepository)
    {
        $this->userAccountRepository = $userAccountRepository;
    }

    public function handle(OpenNewHousehold $command): void
    {
        $creator = $this->userAccountRepository->getByUlid($command->getUserAccountCreatorUlid());

        $creator->createNewHousehold($command->getHouseholdName());

        $this->userAccountRepository->save($creator);
    }
}

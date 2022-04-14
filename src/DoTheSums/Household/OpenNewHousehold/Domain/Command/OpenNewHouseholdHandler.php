<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\OpenNewHousehold\Domain\Command;

use App\DoTheSums\Household\Shared\Domain\Repository\HouseholdRepository;
use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountRepository;

final class OpenNewHouseholdHandler
{
    private HouseholdRepository $householdRepository;
    private UserAccountRepository $userAccountRepository;

    public function __construct(HouseholdRepository $householdRepository, UserAccountRepository $userAccountRepository)
    {
        $this->householdRepository = $householdRepository;
        $this->userAccountRepository = $userAccountRepository;
    }

    public function handle(OpenNewHousehold $command): void
    {
        $creator = $this->userAccountRepository->getByUlid($command->getUserAccountCreatorUlid());

        $newHousehold = $creator->createNewHousehold($command->getHouseholdName());

        $this->householdRepository->save($newHousehold);
    }
}

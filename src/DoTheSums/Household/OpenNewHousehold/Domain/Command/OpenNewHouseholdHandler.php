<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\OpenNewHousehold\Domain\Command;

use App\DoTheSums\Household\Shared\Domain\Repository\HouseholdRepositoryInterface;
use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountRepositoryInterface;

final class OpenNewHouseholdHandler
{
    private HouseholdRepositoryInterface $householdRepository;
    private UserAccountRepositoryInterface $userAccountRepository;

    public function __construct(HouseholdRepositoryInterface $householdRepository, UserAccountRepositoryInterface $userAccountRepository)
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

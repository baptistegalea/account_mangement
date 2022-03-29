<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\OpenNewHousehold\Domain\Command;

use App\DoTheSums\Household\Shared\Domain\Entity\Household;
use App\DoTheSums\Household\Shared\Domain\Repository\HouseholdRepositoryInterface;
use Symfony\Component\Uid\Ulid;

final class OpenNewHouseholdHandler
{
    private HouseholdRepositoryInterface $householdRepository;

    public function __construct(HouseholdRepositoryInterface $householdRepository)
    {
        $this->householdRepository = $householdRepository;
    }

    public function handle(OpenNewHousehold $command): void
    {
        $newHousehold = new Household(
            new Ulid(),
            $command->getHouseholdName(),
            $command->getFirstContributorName(),
            $command->getSecondContributorName()
        );

        $this->householdRepository->save($newHousehold);
    }
}

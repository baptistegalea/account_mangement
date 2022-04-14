<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\AddNewContributor\Domain\Command;

use App\DoTheSums\Household\Shared\Domain\Repository\HouseholdRepository;

final class AddNewContributorHandler
{
    private HouseholdRepository $householdRepository;

    public function __construct(HouseholdRepository $householdRepository)
    {
        $this->householdRepository = $householdRepository;
    }

    public function handle(AddNewContributor $command): void
    {
        $household = $this->householdRepository->getByUlid($command->getHouseholdUlid());

        $household->addContributor($command->getName());
    }
}

<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\RegisterExpense\Domain\Command;

use App\DoTheSums\Household\Shared\Domain\Repository\HouseholdRepositoryInterface;

final class RegisterExpenseHandler
{
    private HouseholdRepositoryInterface $householdRepository;

    public function __construct(HouseholdRepositoryInterface $householdRepository)
    {
        $this->householdRepository = $householdRepository;
    }

    public function handle(RegisterExpense $command): void
    {
        $household = $this->householdRepository->getByUlid($command->getHouseholdUlid());

        $household->registerExpense($command->getContributorUlid(), $command->getAmount(), $command->getDescription(), $command->getRegisteredAt());

        $this->householdRepository->save($household);
    }
}

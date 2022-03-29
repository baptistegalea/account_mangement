<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\RegisterExpense\Domain\Command;

use App\DoTheSums\Household\Shared\Domain\Repository\ContributorRepositoryInterface;

final class RegisterExpenseHandler
{
    private ContributorRepositoryInterface $contributorRepository;

    public function __construct(ContributorRepositoryInterface $contributorRepository)
    {
        $this->contributorRepository = $contributorRepository;
    }

    public function handle(RegisterExpense $command): void
    {
        $contributor = $this->contributorRepository->getByUlid($command->getContributorUlid());

        $contributor->registerNewExpense($command->getAmount(), $command->getDescription());

        $this->contributorRepository->save($contributor);
    }
}

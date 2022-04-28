<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Refund\Domain;

use App\DoTheSums\Household\Shared\Domain\Repository\HouseholdRepository;

final class RefundHandler
{
    private HouseholdRepository $householdRepository;

    public function __construct(HouseholdRepository $householdRepository)
    {
        $this->householdRepository = $householdRepository;
    }

    public function handle(Refund $refund): void
    {
        $household = $this->householdRepository->getByUlid($refund->getHouseholdUlid());

        $contributor = $household->getContributor($refund->getContributorUlid());
        $recipient = $household->getContributor($refund->getRecipientContributorUlid());

        $contributor->refund($recipient, $refund->getAmount());

        $this->householdRepository->save($household);
    }
}

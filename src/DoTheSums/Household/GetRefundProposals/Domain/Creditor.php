<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetRefundProposals\Domain;

use App\DoTheSums\Household\GetRefundProposals\Domain\ValueObject\BalanceAmount;
use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;
use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;

final class Creditor
{
    private NotEmptyName $contributorName;
    private BalanceAmount $currentCredit;

    public function __construct(NotEmptyName $contributorName, BalanceAmount $currentCredit)
    {
        $this->contributorName = $contributorName;
        $this->currentCredit = $currentCredit;
    }

    public function reduceCredit(Amount $amount): void
    {
        $currentCredit = $this->currentCredit->getValue();

        $this->currentCredit = BalanceAmount::fromFloat($currentCredit - $amount->getValue());
    }

    public function getContributorName(): NotEmptyName
    {
        return $this->contributorName;
    }

    public function getCurrentCredit(): BalanceAmount
    {
        return $this->currentCredit;
    }
}

<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetRefundProposals\Domain;

use App\DoTheSums\Household\GetRefundProposals\Domain\ValueObject\BalanceAmount;
use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;
use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;

final class Debtor
{
    private NotEmptyName $contributorName;
    private BalanceAmount $currentDebit;

    public function __construct(NotEmptyName $contributorName, BalanceAmount $currentDebit)
    {
        $this->contributorName = $contributorName;
        $this->currentDebit = $currentDebit;
    }

    public function reduceDebit(Amount $amount): void
    {
        $currentDebit = $this->currentDebit->getValue();

        $this->currentDebit = BalanceAmount::fromFloat($currentDebit - $amount->getValue());
    }

    public function getContributorName(): NotEmptyName
    {
        return $this->contributorName;
    }

    public function getCurrentDebit(): BalanceAmount
    {
        return $this->currentDebit;
    }
}

<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetRefundProposals\Domain\Output;

final class RefundProposal
{
    public string $debtorName;
    public string $creditorName;
    public float $balanceAmount;

    public function __construct(string $debtorName, string $creditorName, float $balanceAmount)
    {
        $this->debtorName = $debtorName;
        $this->creditorName = $creditorName;
        $this->balanceAmount = $balanceAmount;
    }
}

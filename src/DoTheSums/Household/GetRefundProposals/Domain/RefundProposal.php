<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetRefundProposals\Domain;

use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;
use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;

final class RefundProposal
{
    private NotEmptyName $debtorContributorName;
    private NotEmptyName $creditorContributorName;
    private Amount $refundAmout;

    public function __construct(NotEmptyName $debtorContributorName, NotEmptyName $creditorContributorName, Amount $refundAmout)
    {
        $this->debtorContributorName = $debtorContributorName;
        $this->creditorContributorName = $creditorContributorName;
        $this->refundAmout = $refundAmout;
    }

    public function getDebtorContributorName(): NotEmptyName
    {
        return $this->debtorContributorName;
    }

    public function getCreditorContributorName(): NotEmptyName
    {
        return $this->creditorContributorName;
    }

    public function getRefundAmout(): Amount
    {
        return $this->refundAmout;
    }
}

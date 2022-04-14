<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetRefundProposals\Domain;

use App\DoTheSums\Household\Shared\Domain\Entity\Household;
use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;

final class RefundProposalsCalculator
{
    /**
     * @var array<Debtor>
     */
    private array $debtors;
    /**
     * @var array<Creditor>
     */
    private array $creditors;

    public function __construct(Household $household)
    {
        $this->debtors = $household->getDebtors();
        $this->creditors = $household->getCreditors();
    }

    /**
     * @return array<RefundProposal>
     */
    public function getRefundProposals(): array
    {
        $refundProposals = [];
        foreach ($this->debtors as $debtor) {
            foreach ($this->creditors as $creditor) {
                if ($debtor->getCurrentDebit()->getValue() === 0.0) {
                    continue;
                }

                if ($creditor->getCurrentCredit()->getValue() === 0.0) {
                    continue;
                }

                if ($debtor->getCurrentDebit()->getValue() >= $creditor->getCurrentCredit()->getValue()) {
                    $refundAmount = Amount::fromFloat($creditor->getCurrentCredit()->getValue());
                } else {
                    $refundAmount = Amount::fromFloat($debtor->getCurrentDebit()->getValue());
                }

                $debtor->reduceDebit($refundAmount);
                $creditor->reduceCredit($refundAmount);

                $refundProposals[] = new RefundProposal($debtor->getContributorName(), $creditor->getContributorName(), $refundAmount);
            }
        }
        return $refundProposals;
    }
}

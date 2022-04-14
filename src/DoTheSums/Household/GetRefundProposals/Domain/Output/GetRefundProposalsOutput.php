<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetRefundProposals\Domain\Output;

final class GetRefundProposalsOutput
{
    /**
     * @var array<RefundProposal>
     */
    public array $refundProposals;

    /**
     * @param array<RefundProposal> $contributorBalances
     */
    public function __construct(array $contributorBalances)
    {
        $this->refundProposals = $contributorBalances;
    }
}

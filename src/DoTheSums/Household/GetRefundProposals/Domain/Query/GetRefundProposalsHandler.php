<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetRefundProposals\Domain\Query;

use App\DoTheSums\Household\GetRefundProposals\Domain\Output\GetRefundProposalsOutput;
use App\DoTheSums\Household\GetRefundProposals\Domain\Output\RefundProposal;
use App\DoTheSums\Household\GetRefundProposals\Domain\RefundProposalsCalculator;
use App\DoTheSums\Household\GetRefundProposals\Domain\ValueObject\BalanceAmount;
use App\DoTheSums\Household\Shared\Domain\Repository\HouseholdRepository;

final class GetRefundProposalsHandler
{
    private HouseholdRepository $householdRepository;

    public function __construct(HouseholdRepository $householdRepository)
    {
        $this->householdRepository = $householdRepository;
    }

    public function handle(GetRefundProposals $query)
    {
        $household = $this->householdRepository->getByUlid($query->getUlidHousehold());

        $refundProposalsCalculator = new RefundProposalsCalculator($household);

        $outputRefundProposals = [];
        foreach ($refundProposalsCalculator->getRefundProposals() as $refundProposal) {
            $outputRefundProposals[] = new RefundProposal(
                $refundProposal->getDebtorContributorName()->getValue(),
                $refundProposal->getCreditorContributorName()->getValue(),
                BalanceAmount::fromFloat($refundProposal->getRefundAmout()->getValue())->rounded(),
            );
        }

        return new GetRefundProposalsOutput($outputRefundProposals);
    }
}

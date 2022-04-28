<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Refund\Domain;

use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;
use Symfony\Component\Uid\Ulid;

final class Refund
{
    private Ulid $householdUlid;
    private Ulid $contributorUlid;
    private Ulid $recipientContributorUlid;
    private Amount $amount;

    public function __construct(Ulid $householdUlid, Ulid $contributorUlid, Ulid $recipientContributorUlid, Amount $amount)
    {
        $this->householdUlid = $householdUlid;
        $this->contributorUlid = $contributorUlid;
        $this->recipientContributorUlid = $recipientContributorUlid;
        $this->amount = $amount;
    }

    public function getHouseholdUlid(): Ulid
    {
        return $this->householdUlid;
    }

    public function getContributorUlid(): Ulid
    {
        return $this->contributorUlid;
    }

    public function getRecipientContributorUlid(): Ulid
    {
        return $this->recipientContributorUlid;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }
}

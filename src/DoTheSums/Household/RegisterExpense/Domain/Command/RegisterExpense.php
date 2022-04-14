<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\RegisterExpense\Domain\Command;

use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;
use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use Symfony\Component\Uid\Ulid;

final class RegisterExpense
{
    private Ulid $contributorUlid;
    private Amount $amount;
    private NotEmptyName $description;
    private \DateTimeImmutable $registeredAt;
    private Ulid $householdUlid;

    public function __construct(Ulid $householdUlid, Ulid $contributorUlid, Amount $amount, NotEmptyName $description, \DateTimeImmutable $registeredAt)
    {
        $this->contributorUlid = $contributorUlid;
        $this->amount = $amount;
        $this->description = $description;
        $this->registeredAt = $registeredAt;
        $this->householdUlid = $householdUlid;
    }

    public function getHouseholdUlid(): Ulid
    {
        return $this->householdUlid;
    }

    public function getContributorUlid(): Ulid
    {
        return $this->contributorUlid;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getDescription(): NotEmptyName
    {
        return $this->description;
    }

    public function getRegisteredAt(): \DateTimeImmutable
    {
        return $this->registeredAt;
    }
}

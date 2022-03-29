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

    public function __construct(Ulid $contributorUlid, Amount $amount, NotEmptyName $description)
    {
        $this->contributorUlid = $contributorUlid;
        $this->amount = $amount;
        $this->description = $description;
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
}

<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\RegisterExpense\Presentation\Http;

final class RegisterExpensePayloadInput
{
    private string $contributorUlid;
    private float $amount;
    private string $description;

    public function __construct(string $contributorUlid, float $amount, string $description)
    {
        $this->contributorUlid = $contributorUlid;
        $this->amount = $amount;
        $this->description = $description;
    }

    public function getContributorUlid(): string
    {
        return $this->contributorUlid;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

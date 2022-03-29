<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\RegisterExpense\Presentation\Http;

final class RegisterExpensePayloadInput
{
    public string $contributorUlid;

    public float $amount;

    public string $description;
}

<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Refund\Presentation\Http;

final class RefundInput
{
    public string $recipientUlid;
    public float $amount;
}

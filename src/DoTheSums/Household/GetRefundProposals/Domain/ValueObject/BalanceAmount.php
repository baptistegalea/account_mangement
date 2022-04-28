<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetRefundProposals\Domain\ValueObject;

final class BalanceAmount
{
    private float $value;

    private function __construct(float $amount)
    {
        $this->value = $amount;
    }

    public static function fromFloat(float $amount): self
    {
        return new self(round($amount, 2));
    }

    public function rounded(): float
    {
        return round($this->value, 2);
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function isNegative(): bool
    {
        return $this->value < 0;
    }

    public function isPositive(): bool
    {
        return $this->value > 0;
    }

    public function toPositive(): self
    {
        if ($this->isPositive()) {
            return $this;
        }

        return new self($this->value * -1);
    }
}

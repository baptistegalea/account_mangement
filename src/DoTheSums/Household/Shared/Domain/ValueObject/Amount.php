<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Domain\ValueObject;

final class Amount
{
    private float $value;

    private function __construct(float $amount)
    {
        $this->value = $amount;
    }

    public static function fromFloat(float $amount): self
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('An amount must be positive');
        }

        return new self($amount);
    }

    public function getValue(): float
    {
        return $this->value;
    }
}

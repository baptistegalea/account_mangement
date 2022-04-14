<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetHouseholdContributors\Domain\Output;

final class Contributor
{
    private string $ulid;
    private string $name;

    public function __construct(string $ulid, string $name)
    {
        $this->ulid = $ulid;
        $this->name = $name;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

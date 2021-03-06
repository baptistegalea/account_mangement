<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetHouseholdContributors\Domain\Output;

final class Contributor
{
    public string $ulid;
    public string $name;

    public function __construct(string $ulid, string $name)
    {
        $this->ulid = $ulid;
        $this->name = $name;
    }
}

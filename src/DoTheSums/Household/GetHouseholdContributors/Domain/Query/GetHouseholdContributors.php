<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetHouseholdContributors\Domain\Query;

use Symfony\Component\Uid\Ulid;

final class GetHouseholdContributors
{
    private Ulid $householdUlid;

    public function __construct(Ulid $householdUlid)
    {
        $this->householdUlid = $householdUlid;
    }

    public function getHouseholdUlid(): Ulid
    {
        return $this->householdUlid;
    }
}

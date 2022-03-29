<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\OpenNewHousehold\Domain\Command;

use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;

final class OpenNewHousehold
{
    private NotEmptyName $householdName;
    private NotEmptyName $firstContributorName;
    private NotEmptyName $secondContributorName;

    public function __construct(NotEmptyName $householdName, NotEmptyName $firstContributorName, NotEmptyName $secondContributorName)
    {
        $this->secondContributorName = $secondContributorName;
        $this->firstContributorName = $firstContributorName;
        $this->householdName = $householdName;
    }

    public function getHouseholdName(): NotEmptyName
    {
        return $this->householdName;
    }

    public function getFirstContributorName(): NotEmptyName
    {
        return $this->firstContributorName;
    }

    public function getSecondContributorName(): NotEmptyName
    {
        return $this->secondContributorName;
    }
}

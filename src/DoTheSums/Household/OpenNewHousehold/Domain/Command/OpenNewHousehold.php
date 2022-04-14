<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\OpenNewHousehold\Domain\Command;

use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use Symfony\Component\Uid\Ulid;

final class OpenNewHousehold
{
    private NotEmptyName $householdName;
    private Ulid $userAccountCreatorUlid;

    public function __construct(NotEmptyName $householdName, Ulid $userAccountCreatorUlid)
    {
        $this->householdName = $householdName;
        $this->userAccountCreatorUlid = $userAccountCreatorUlid;
    }

    public function getHouseholdName(): NotEmptyName
    {
        return $this->householdName;
    }

    public function getUserAccountCreatorUlid(): Ulid
    {
        return $this->userAccountCreatorUlid;
    }
}

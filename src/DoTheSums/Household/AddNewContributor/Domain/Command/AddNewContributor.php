<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\AddNewContributor\Domain\Command;

use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use Symfony\Component\Uid\Ulid;

final class AddNewContributor
{
    private Ulid $householdUlid;
    private NotEmptyName $name;

    public function __construct(Ulid $householdUlid, NotEmptyName $name)
    {
        $this->householdUlid = $householdUlid;
        $this->name = $name;
    }

    public function getHouseholdUlid(): Ulid
    {
        return $this->householdUlid;
    }

    public function getName(): NotEmptyName
    {
        return $this->name;
    }
}

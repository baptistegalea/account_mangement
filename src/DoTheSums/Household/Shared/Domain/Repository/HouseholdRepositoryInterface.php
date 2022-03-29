<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Domain\Repository;

use App\DoTheSums\Household\Shared\Domain\Entity\Household;
use Symfony\Component\Uid\Ulid;

interface HouseholdRepositoryInterface
{
    public function save(Household $household): void;

    public function getByUlid(Ulid $ulid): Household;
}

<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Domain\Repository;

use App\DoTheSums\Household\Shared\Domain\Entity\Contributor;
use Symfony\Component\Uid\Ulid;

interface ContributorRepositoryInterface
{
    public function getByUlid(Ulid $ulid): Contributor;

    public function save(Contributor $contributor): void;
}

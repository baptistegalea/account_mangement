<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Domain\Repository;

use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccountCreationRequest;
use Symfony\Component\Uid\Ulid;

interface UserAccountCreationRequestRepositoryInterface
{
    public function getByUlid(Ulid $ulid): UserAccountCreationRequest;

    public function save(UserAccountCreationRequest $userAccountCreationRequest): void;
}

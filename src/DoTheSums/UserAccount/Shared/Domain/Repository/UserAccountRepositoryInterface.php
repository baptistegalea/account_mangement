<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Domain\Repository;

use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccount;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Email;
use Symfony\Component\Uid\Ulid;

interface UserAccountRepositoryInterface
{
    public function getByUlid(Ulid $ulid): UserAccount;

    public function findByEmail(Email $email): ?UserAccount;

    public function save(UserAccount $userAccount): void;
}

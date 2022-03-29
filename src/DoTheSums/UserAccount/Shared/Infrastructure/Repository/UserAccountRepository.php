<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Infrastructure\Repository;

use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccount;
use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountRepositoryInterface;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Ulid;

final class UserAccountRepository implements UserAccountRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getByUlid(Ulid $ulid): UserAccount
    {
        $userAccount = $this->entityManager->getRepository(UserAccount::class)->findOneBy([
            'ulid' => $ulid
        ]);

        if ($userAccount instanceof UserAccount === false) {
            throw new \Exception(sprintf('User account %s is not found', $ulid->toRfc4122()));
        }

        return $userAccount;
    }

    public function findByEmail(Email $email): ?UserAccount
    {
        return $this->entityManager->getRepository(UserAccount::class)->findOneBy([
            'email' => $email
        ]);
    }


    public function save(UserAccount $userAccount): void
    {
        $this->entityManager->persist($userAccount);
        $this->entityManager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Infrastructure\Repository;

use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccountCreationRequest;
use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountCreationRequestRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Ulid;

final class UserAccountCreationRequestRepository implements UserAccountCreationRequestRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getByUlid(Ulid $ulid): UserAccountCreationRequest
    {
        $userAccountCreationRequest = $this->entityManager->getRepository(UserAccountCreationRequest::class)->findOneBy([
            'ulid' => $ulid
        ]);

        if ($userAccountCreationRequest instanceof UserAccountCreationRequest === false) {
            throw new \Exception(sprintf('User account creation request %s is not found', $ulid->toRfc4122()));
        }

        return $userAccountCreationRequest;
    }

    public function save(UserAccountCreationRequest $userAccountCreationRequest): void
    {
        $this->entityManager->persist($userAccountCreationRequest);
        $this->entityManager->flush();
    }
}

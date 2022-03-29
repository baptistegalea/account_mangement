<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Infrastructure\Repository;

use App\DoTheSums\Household\Shared\Domain\Entity\Household;
use App\DoTheSums\Household\Shared\Domain\Repository\HouseholdRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Ulid;

final class HouseholdRepository implements HouseholdRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Household $household): void
    {
        $this->entityManager->persist($household);
        $this->entityManager->flush();
    }

    public function getByUlid(Ulid $ulid): Household
    {
        $household = $this->entityManager->getRepository(Household::class)->findOneBy([
            'ulid' => $ulid
        ]);

        if ($household instanceof Household === false) {
            throw new \Exception(sprintf('Household %s is not found', $ulid->toRfc4122()));
        }

        return $household;
    }
}

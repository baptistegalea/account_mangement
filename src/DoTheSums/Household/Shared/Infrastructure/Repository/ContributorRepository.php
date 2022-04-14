<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Infrastructure\Repository;

use App\DoTheSums\Household\Shared\Domain\Entity\Contributor;
use App\DoTheSums\Household\Shared\Domain\Repository\ContributorRepository as ContributorRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Ulid;

final class ContributorRepository implements ContributorRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getByUlid(Ulid $ulid): Contributor
    {
        $contributor = $this->entityManager->getRepository(Contributor::class)->findOneBy([
            'ulid' => $ulid,
        ]);

        if ($contributor instanceof Contributor === false) {
            throw new \Exception(sprintf('Contributor %s is not found', $ulid->toRfc4122()));
        }

        return $contributor;
    }

    public function save(Contributor $contributor): void
    {
        $this->entityManager->persist($contributor);
        $this->entityManager->flush();
    }
}

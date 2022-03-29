<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetHouseholdContributors\Domain\Query;

use App\DoTheSums\Household\GetHouseholdContributors\Domain\Output\Contributor;
use App\DoTheSums\Household\GetHouseholdContributors\Domain\Output\GetHouseholdContributorsOutput;
use App\DoTheSums\Household\Shared\Domain\Repository\HouseholdRepositoryInterface;

final class GetHouseholdContributorsHandler
{
    private HouseholdRepositoryInterface $householdRepository;

    public function __construct(HouseholdRepositoryInterface $householdRepository)
    {
        $this->householdRepository = $householdRepository;
    }

    public function handle(GetHouseholdContributors $query): GetHouseholdContributorsOutput
    {
        $household = $this->householdRepository->getByUlid($query->getHouseholdUlid());

        $output = new GetHouseholdContributorsOutput();
        foreach ($household->getContributors() as $contributorEntity) {
            $contributor = new Contributor();
            $contributor->ulid = $contributorEntity->getUlid()->toRfc4122();
            $contributor->name = $contributorEntity->getName()->getValue();
            $output->contributors[] = $contributor;
        }

        return $output;
    }
}

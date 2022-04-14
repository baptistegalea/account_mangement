<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetHouseholdContributors\Domain\Query;

use App\DoTheSums\Household\GetHouseholdContributors\Domain\Output\Contributor;
use App\DoTheSums\Household\GetHouseholdContributors\Domain\Output\GetHouseholdContributorsOutput;
use App\DoTheSums\Household\Shared\Domain\Repository\HouseholdRepository;

final class GetHouseholdContributorsHandler
{
    private HouseholdRepository $householdRepository;

    public function __construct(HouseholdRepository $householdRepository)
    {
        $this->householdRepository = $householdRepository;
    }

    public function handle(GetHouseholdContributors $query): GetHouseholdContributorsOutput
    {
        $household = $this->householdRepository->getByUlid($query->getHouseholdUlid());

        $contributors = [];
        foreach ($household->getContributors() as $contributorEntity) {
            $contributor = new Contributor(
                $contributorEntity->getUlid()->toRfc4122(),
                $contributorEntity->getName()->getValue()
            );
            $contributors[] = $contributor;
        }

        return new GetHouseholdContributorsOutput($contributors);
    }
}

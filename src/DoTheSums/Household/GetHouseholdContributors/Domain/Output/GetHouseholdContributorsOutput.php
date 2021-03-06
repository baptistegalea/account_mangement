<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetHouseholdContributors\Domain\Output;

final class GetHouseholdContributorsOutput
{
    /**
     * @var array<Contributor>
     */
    public array $contributors;

    /**
     * @param array<Contributor> $contributors
     */
    public function __construct(array $contributors)
    {
        $this->contributors = $contributors;
    }
}

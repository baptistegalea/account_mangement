<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetHouseholdContributors\Domain\Output;

final class GetHouseholdContributorsOutput
{
    /**
     * @var array<Contributor>
     */
    private array $contributors;

    /**
     * @param array<Contributor> $contributors
     */
    public function __construct(array $contributors)
    {
        $this->contributors = $contributors;
    }

    /**
     * @return array<Contributor>
     */
    public function getContributors(): array
    {
        return $this->contributors;
    }
}

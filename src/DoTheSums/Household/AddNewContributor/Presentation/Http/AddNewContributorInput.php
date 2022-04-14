<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\AddNewContributor\Presentation\Http;

final class AddNewContributorInput
{
    private string $contributorName;

    public function __construct(string $contributorName)
    {
        $this->contributorName = $contributorName;
    }

    public function getContributorName(): string
    {
        return $this->contributorName;
    }
}

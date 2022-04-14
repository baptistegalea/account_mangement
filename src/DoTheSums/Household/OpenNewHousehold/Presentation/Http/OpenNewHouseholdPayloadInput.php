<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\OpenNewHousehold\Presentation\Http;

final class OpenNewHouseholdPayloadInput
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

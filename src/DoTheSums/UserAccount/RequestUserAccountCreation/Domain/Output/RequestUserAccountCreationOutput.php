<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\RequestUserAccountCreation\Domain\Output;

final class RequestUserAccountCreationOutput
{
    private string $ulid;

    public function __construct(string $ulid)
    {
        $this->ulid = $ulid;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }
}

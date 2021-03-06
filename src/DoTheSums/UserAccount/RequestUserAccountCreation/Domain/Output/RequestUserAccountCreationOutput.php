<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\RequestUserAccountCreation\Domain\Output;

final class RequestUserAccountCreationOutput
{
    public string $ulid;

    public function __construct(string $ulid)
    {
        $this->ulid = $ulid;
    }
}

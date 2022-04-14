<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\AuthenticateWithEmailAndPassword\Domain\Service;

use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccount;

interface JWTIssuer
{
    public function issueJWT(UserAccount $userAccount): string;
}
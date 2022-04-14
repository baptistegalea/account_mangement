<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\AuthenticateWithEmailAndPassword\Infrastructure\Service;

use App\DoTheSums\UserAccount\AuthenticateWithEmailAndPassword\Domain\Service\JWTIssuer as JWTIssuerInterface;
use App\DoTheSums\Shared\Domain\Entity\UserAccount;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

final class JWTIssuer implements JWTIssuerInterface
{
    public function issueJWT(UserAccount $userAccount): string
    {
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText('MySuperHashKey!!')
        );

        $now = new \DateTimeImmutable();
        $token = $configuration->builder()
            ->issuedAt($now)
            ->expiresAt($now->modify('+24 hours'))
            ->withClaim('email', $userAccount->getEmail()->getValue())
            // Builds a new token
            ->getToken($configuration->signer(), $configuration->signingKey());

        return $token->toString();
    }
}

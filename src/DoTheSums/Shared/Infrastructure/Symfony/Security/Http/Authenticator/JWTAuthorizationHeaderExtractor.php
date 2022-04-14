<?php

declare(strict_types=1);

namespace App\DoTheSums\Shared\Infrastructure\Symfony\Security\Http\Authenticator;

use Symfony\Component\HttpFoundation\Request;

final class JWTAuthorizationHeaderExtractor
{
    /**
     * Returns the JWT from the Authorization header
     */
    public function extract(Request $request): ?string
    {
        if ($request->headers->has('Authorization') === false) {
            return null;
        }

        $authorizationHeader = $request->headers->get('Authorization');

        if ($authorizationHeader === null) {
            throw new \Exception('Authorization Header not found');
        }

        $headerParts = explode(' ', $authorizationHeader);

        if (strcasecmp($headerParts[0], 'Bearer') !== 0) {
            return null;
        }

        return $headerParts[1];
    }
}

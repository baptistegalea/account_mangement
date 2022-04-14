<?php

declare(strict_types=1);

namespace App\DoTheSums\Shared\Infrastructure\Symfony\Security\Http\Authenticator;

use App\DoTheSums\UserAccount\Shared\Domain\Repository\UserAccountRepository;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Email;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class JWTAuthenticator extends AbstractAuthenticator
{
    private JWTAuthorizationHeaderExtractor $authorizationHeaderExtractor;
    private UserAccountRepository $userAccountRepository;

    public function __construct(JWTAuthorizationHeaderExtractor $authorizationHeaderExtractor, UserAccountRepository $userAccountRepository)
    {
        $this->authorizationHeaderExtractor = $authorizationHeaderExtractor;
        $this->userAccountRepository = $userAccountRepository;
    }

    public function supports(Request $request): ?bool
    {
        return $this->authorizationHeaderExtractor->extract($request) !== null;
    }

    public function authenticate(Request $request): Passport
    {
        $jwt = $this->authorizationHeaderExtractor->extract($request);

        if ($jwt === null) {
            throw new \Exception('JWT not found while authenticating');
        }
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText('MySuperHashKey!!')
        );

        $configuration->setValidationConstraints(
            new LooseValidAt(SystemClock::fromSystemTimezone())
        );

        $token = $configuration->parser()->parse($jwt);

        if ($configuration->validator()->validate($token, ...$configuration->validationConstraints()) === false) {
            throw new \Exception('JWT not valid');
        }

        if ($token instanceof UnencryptedToken === false) {
            throw new \Exception('Token is encrypted');
        }

        $email = $token->claims()->get('email');

        return new SelfValidatingPassport(
            new UserBadge($email, function (string $userIdentifier) {
                $email = Email::fromString($userIdentifier);
                $userAccount = $this->userAccountRepository->findByEmail($email);

                if ($userAccount === null) {
                    return null;
                }

                return new User($userAccount);
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // do nothing here, let the request continuing.
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['error' => 'Authentication failed', Response::HTTP_UNAUTHORIZED]);
    }
}

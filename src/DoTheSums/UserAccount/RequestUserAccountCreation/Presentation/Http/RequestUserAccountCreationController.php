<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\RequestUserAccountCreation\Presentation\Http;

use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use App\DoTheSums\UserAccount\RequestUserAccountCreation\Domain\Command\RequestUserAccountCreation;
use App\DoTheSums\UserAccount\RequestUserAccountCreation\Domain\Command\RequestUserAccountCreationHandler;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Email;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Password;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class RequestUserAccountCreationController extends AbstractController
{
    /**
     * @Route(path="/user-account-creation-requests", methods={"POST"})
     */
    public function __invoke(RequestUserAccountCreationHandler $handler, RequestUserAccountCreationInput $requestUserAccountCreationInput): JsonResponse
    {
        $output = $handler->handle(
            new RequestUserAccountCreation(
                Email::fromString($requestUserAccountCreationInput->getEmail()),
                NotEmptyName::fromString($requestUserAccountCreationInput->getName()),
                Password::fromString($requestUserAccountCreationInput->getPassword()),
                new \DateTimeImmutable(),
            )
        );

        return new JsonResponse($output);
    }
}

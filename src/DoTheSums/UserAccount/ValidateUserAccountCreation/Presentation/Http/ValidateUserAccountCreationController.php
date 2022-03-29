<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\ValidateUserAccountCreation\Presentation\Http;

use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\OneTimePassword;
use App\DoTheSums\UserAccount\ValidateUserAccountCreation\Domain\Command\ValidateUserAccountCreation;
use App\DoTheSums\UserAccount\ValidateUserAccountCreation\Domain\Command\ValidateUserAccountCreationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

final class ValidateUserAccountCreationController extends  AbstractController
{
    /**
     * @Route(path="/user-account-creation-requests/{ulid}/confirm", methods={"POST"})
     */
    public function __invoke(string $ulid, ValidateUserAccountCreationHandler $handler, ValidateUserAccountCreationInput $requestUserAccountCreationInput): JsonResponse
    {
        $handler->handle(
            new ValidateUserAccountCreation(
                Ulid::fromString($ulid),
                OneTimePassword::fromString($requestUserAccountCreationInput->otp)
            ));

        return new JsonResponse();
    }
}

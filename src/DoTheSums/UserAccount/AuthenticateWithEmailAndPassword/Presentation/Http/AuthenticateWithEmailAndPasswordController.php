<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\AuthenticateWithEmailAndPassword\Presentation\Http;

use App\DoTheSums\UserAccount\AuthenticateWithEmailAndPassword\Domain\Command\AuthenticateWithEmailAndPassword;
use App\DoTheSums\UserAccount\AuthenticateWithEmailAndPassword\Domain\Command\AuthenticateWithEmailAndPasswordHandler;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class AuthenticateWithEmailAndPasswordController extends AbstractController
{
    /**
     * @Route(path="/auth/email-password", methods={"POST"})
     */
    public function __invoke(AuthenticateWithEmailAndPasswordHandler $handler, AuthenticateWithEmailAndPasswordInput $registerExpenseInput): JsonResponse
    {
        $jwt = $handler->handle(
            new AuthenticateWithEmailAndPassword(
                Email::fromString($registerExpenseInput->email),
                $registerExpenseInput->password
            ));

        return new JsonResponse(['jwt' => $jwt]);
    }
}

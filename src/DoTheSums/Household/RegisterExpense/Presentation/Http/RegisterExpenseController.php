<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\RegisterExpense\Presentation\Http;

use App\DoTheSums\Household\RegisterExpense\Domain\Command\RegisterExpense;
use App\DoTheSums\Household\RegisterExpense\Domain\Command\RegisterExpenseHandler;
use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;
use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

final class RegisterExpenseController extends AbstractController
{
    /**
     * @Route(path="/expenses", methods={"POST"})
     */
    public function __invoke(RegisterExpenseHandler $handler, RegisterExpensePayloadInput $registerExpenseInput): JsonResponse
    {
        $handler->handle(
            new RegisterExpense(
                Ulid::fromString($registerExpenseInput->contributorUlid),
                Amount::fromFloat($registerExpenseInput->amount),
                NotEmptyName::fromString($registerExpenseInput->description)
            ));

        return new JsonResponse();
    }
}

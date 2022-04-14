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
     * @Route(path="/households/{householdUlid}/expenses", methods={"POST"})
     */
    public function __invoke(RegisterExpenseHandler $handler, string $householdUlid, RegisterExpensePayloadInput $registerExpenseInput): JsonResponse
    {
        $handler->handle(
            new RegisterExpense(
                Ulid::fromString($householdUlid),
                Ulid::fromString($registerExpenseInput->getContributorUlid()),
                Amount::fromFloat($registerExpenseInput->getAmount()),
                NotEmptyName::fromString($registerExpenseInput->getDescription()),
                new \DateTimeImmutable()
            )
        );

        return new JsonResponse();
    }
}

<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\OpenNewHousehold\Presentation\Http;

use App\DoTheSums\Household\OpenNewHousehold\Domain\Command\OpenNewHousehold;
use App\DoTheSums\Household\OpenNewHousehold\Domain\Command\OpenNewHouseholdHandler;
use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use App\DoTheSums\UserAccount\Shared\Infrastructure\Symfony\Security\AuthUserAccountStorage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class OpenNewHouseholdController extends AbstractController
{
    /**
     * @Route(path="/households", methods={"POST"})
     */
    public function __invoke(OpenNewHouseholdHandler $handler, OpenNewHouseholdPayloadInput $input, AuthUserAccountStorage $authUserAccountStorage): JsonResponse
    {
        $handler->handle(
            new OpenNewHousehold(
                NotEmptyName::fromString($input->getName()),
                $authUserAccountStorage->getAuthenticatedUserAccount()->getUlid()
            )
        );

        return new JsonResponse();
    }
}

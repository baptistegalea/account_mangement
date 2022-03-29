<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetHouseholdContributors\Presentation\Http;

use App\DoTheSums\Household\GetHouseholdContributors\Domain\Query\GetHouseholdContributors;
use App\DoTheSums\Household\GetHouseholdContributors\Domain\Query\GetHouseholdContributorsHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

final class GetHouseholdContributorsController extends AbstractController
{
    /**
     * @Route(path="/households/{ulid}/contributors", methods={"GET"})
     */
    public function __invoke(GetHouseholdContributorsHandler $handler, string $ulid): JsonResponse
    {
        $contributors = $handler->handle(
            new GetHouseholdContributors(Ulid::fromString($ulid))
        );

        return new JsonResponse($contributors);
    }
}

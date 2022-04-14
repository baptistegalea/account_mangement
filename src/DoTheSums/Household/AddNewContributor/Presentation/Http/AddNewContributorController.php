<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\AddNewContributor\Presentation\Http;

use App\DoTheSums\Household\AddNewContributor\Domain\Command\AddNewContributor;
use App\DoTheSums\Household\AddNewContributor\Domain\Command\AddNewContributorHandler;
use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

final class AddNewContributorController extends AbstractController
{
    /**
     * @Route(path="/households/{ulid}/contributors", methods={"POST"})
     */
    public function __invoke(AddNewContributorHandler $handler, string $ulid, AddNewContributorInput $addNewContributorInput): JsonResponse
    {
        $handler->handle(
            new AddNewContributor(
                Ulid::fromString($ulid),
                NotEmptyName::fromString($addNewContributorInput->getContributorName())
            )
        );

        return new JsonResponse();
    }
}

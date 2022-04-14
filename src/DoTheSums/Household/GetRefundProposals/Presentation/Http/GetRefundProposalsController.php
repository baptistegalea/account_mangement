<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetRefundProposals\Presentation\Http;

use App\DoTheSums\Household\GetRefundProposals\Domain\Query\GetRefundProposals;
use App\DoTheSums\Household\GetRefundProposals\Domain\Query\GetRefundProposalsHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

final class GetRefundProposalsController extends AbstractController
{
    /**
     * @Route(path="/households/{ulid}/refund-proposals", methods={"GET"})
     */
    public function __invoke(GetRefundProposalsHandler $handler, string $ulid): JsonResponse
    {
        $balances = $handler->handle(
            new GetRefundProposals(Ulid::fromString($ulid))
        );

        return new JsonResponse($balances);
    }
}

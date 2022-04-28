<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Refund\Presentation\Http;

use App\DoTheSums\Household\Refund\Domain\Refund;
use App\DoTheSums\Household\Refund\Domain\RefundHandler;
use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

final class RefundController extends AbstractController
{
    /**
     * @Route(path="/households/{householdUlid}/contributors/{contributorUlid}/refund", methods={"POST"})
     */
    public function __invoke(RefundHandler $handler, RefundInput $input, string $householdUlid, string $contributorUlid): JsonResponse
    {
        $handler->handle(
            new Refund(
                Ulid::fromString($householdUlid),
                Ulid::fromString($contributorUlid),
                Ulid::fromString($input->recipientUlid),
                Amount::fromFloat($input->amount),
            )
        );

        return new JsonResponse();
    }
}

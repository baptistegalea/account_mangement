<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\GetRefundProposals\Domain\Query;

use Symfony\Component\Uid\Ulid;

final class GetRefundProposals
{
    private Ulid $ulidHousehold;

    public function __construct(Ulid $ulidHousehold)
    {
        $this->ulidHousehold = $ulidHousehold;
    }

    public function getUlidHousehold(): Ulid
    {
        return $this->ulidHousehold;
    }
}

<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Domain\Entity;

use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Ulid;

#[Entity]
class Refund
{
    #[Id]
    #[Column(type: 'ulid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private Ulid $ulid;

    #[ManyToOne(targetEntity: Contributor::class, inversedBy: 'refunds')]
    #[JoinColumn(name: 'contributor_ulid', referencedColumnName: 'ulid', nullable: false)]
    private Contributor $contributor;

    #[ManyToOne(targetEntity: Contributor::class, inversedBy: 'incomingRefunds')]
    #[JoinColumn(name: 'recipient_ulid', referencedColumnName: 'ulid', nullable: false)]
    private Contributor $recipient;

    #[Column(type: 'amount', nullable: false, options: ['unsigned' => true])]
    private Amount $amount;

    public function __construct(Contributor $contributor, Contributor $recipient, Amount $amount)
    {
        $this->ulid = new Ulid();
        $this->contributor = $contributor;
        $this->recipient = $recipient;
        $this->amount = $amount;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }
}

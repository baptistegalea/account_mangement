<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Domain\Entity;

use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;
use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Ulid;

#[Entity]
class Expense
{
    #[Id]
    #[Column(type: 'ulid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private Ulid $ulid;

    #[Column(type: 'amount', nullable: false, options: ['unsigned' => true])]
    private Amount $amount;

    #[ManyToOne(targetEntity: Contributor::class, inversedBy: 'expenses')]
    #[JoinColumn(name: 'contributor_ulid', referencedColumnName: 'ulid', nullable: false)]
    private Contributor $contributor;

    #[Column(type: 'datetime', nullable: false)]
    private \DateTime $registeredAt;

    #[Column(type: 'not_empty_name', nullable: false)]
    private NotEmptyName $description;

    public function __construct(Contributor $payer, Amount $amount, NotEmptyName $description, \DateTimeImmutable $registeredAt)
    {
        $this->ulid = new Ulid();
        $this->contributor = $payer;
        $this->amount = $amount;
        $this->registeredAt = \DateTime::createFromImmutable($registeredAt);
        $this->description = $description;
    }

    public function getUlid(): Ulid
    {
        return $this->ulid;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getContributor(): Contributor
    {
        return $this->contributor;
    }

    public function getRegisteredAt(): \DateTime
    {
        return $this->registeredAt;
    }

    public function getDescription(): NotEmptyName
    {
        return $this->description;
    }
}

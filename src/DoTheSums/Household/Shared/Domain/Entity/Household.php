<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Domain\Entity;

use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Ulid;

#[Entity]
class Household
{
    #[Id]
    #[Column(type: 'ulid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private Ulid $ulid;

    #[Column(type: "not_empty_name", nullable: false)]
    private NotEmptyName $name;

    #[OneToMany(mappedBy: "household", targetEntity: "Contributor", cascade: ["persist" => "persist"])]
    private Collection $contributors;

    public function __construct(Ulid $ulid, NotEmptyName $name, NotEmptyName $firtContributorName, NotEmptyName $secondContributorName)
    {
        $this->ulid = $ulid;
        $this->name = $name;

        if ($firtContributorName->equals($secondContributorName)) {
            throw new \InvalidArgumentException('Both contributors must have a different name');
        }

        $this->contributors = new ArrayCollection(
            [
                new Contributor(new Ulid(), $this, $firtContributorName),
                new Contributor(new Ulid(), $this, $secondContributorName),
            ]
        );
    }

    public function getUlid(): Ulid
    {
        return $this->ulid;
    }

    public function getName(): NotEmptyName
    {
        return $this->name;
    }

    /**
     * @return array<Contributor>
     */
    public function getContributors(): array
    {
        return $this->contributors->toArray();
    }

    public function getBalance(): array
    {
        /** @var Contributor $firstContributor */
        $firstContributor = $this->contributors->first();
        /** @var Contributor $secondContributor */
        $secondContributor = $this->contributors->last();

        $totalSpent = $firstContributor->getTotalSpent()->getValue() + $secondContributor->getTotalSpent()->getValue();

        $supposedAmountSpent = $totalSpent / 2;

        $firstContributorBalance = $supposedAmountSpent - $firstContributor->getTotalSpent()->getValue();
        $secondContributorBalance = $supposedAmountSpent - $secondContributor->getTotalSpent()->getValue();

        return [
            'firstContributorDebt' => $firstContributorBalance > 0 ? $firstContributorBalance : 0,
            'secondContributorDebt' => $secondContributorBalance > 0 ? $secondContributorBalance : 0,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Domain\Entity;

use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccount;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
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

    #[OneToMany(mappedBy: "household", targetEntity: Contributor::class, cascade: ["persist" => "persist"])]
    private Collection $contributors;

    #[ManyToOne(targetEntity: UserAccount::class, inversedBy: "households")]
    #[JoinColumn(name: "creator_ulid", referencedColumnName: "ulid", nullable: false)]
    private UserAccount $creator;

    private function __construct(NotEmptyName $name, UserAccount $creator)
    {
        $this->ulid = new Ulid();
        $this->name = $name;
        $this->creator = $creator;

        $this->contributors = new ArrayCollection(
            [
                new Contributor($this, $creator->getName()),
            ]
        );
    }

    public static function openNewHouseHold(NotEmptyName $name, UserAccount $creator): self
    {
        return new self($name, $creator);
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

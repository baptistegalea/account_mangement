<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Domain\Entity;

use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;
use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
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
class Contributor
{
    #[Id]
    #[Column(type: 'ulid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private Ulid $ulid;

    #[Column(type: "not_empty_name", length: 255, nullable: false)]
    private NotEmptyName $name;

    #[ManyToOne(targetEntity: Household::class, inversedBy: "contributors")]
    #[JoinColumn(name: "household_ulid", referencedColumnName: "ulid", nullable: false)]
    private Household $household;

    #[OneToMany(mappedBy: "contributor", targetEntity: Expense::class, cascade: ["persist" => "persist"])]
    private Collection $expenses;

    public function __construct(Household $household, NotEmptyName $name)
    {
        $this->ulid = new Ulid();
        $this->household = $household;
        $this->name = $name;
        $this->expenses = new ArrayCollection();
    }

    public function getUlid(): Ulid
    {
        return $this->ulid;
    }

    public function getName(): NotEmptyName
    {
        return $this->name;
    }

    public function getHousehold(): Household
    {
        return $this->household;
    }

    /**
     * @return array<Expense>
     */
    public function getExpenses(): array
    {
        return $this->expenses->toArray();
    }

    public function getTotalSpent(): Amount
    {
        return \array_reduce($this->expenses->toArray(),
             static function (Amount $lastAmount, Expense $expense) {
                return Amount::fromFloat($lastAmount->getValue() + $expense->getAmount()->getValue());
            },
        Amount::fromFloat(0));
    }

    public function registerNewExpense(Amount $amount, NotEmptyName $description, \DateTimeImmutable $registeredAt): void
    {
        $this->expenses->add(new Expense($this, $amount, $description, $registeredAt));
    }
}

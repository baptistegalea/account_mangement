<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Domain\Entity;

use App\DoTheSums\Household\GetRefundProposals\Domain\Creditor;
use App\DoTheSums\Household\GetRefundProposals\Domain\Debtor;
use App\DoTheSums\Household\GetRefundProposals\Domain\ValueObject\BalanceAmount;
use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;
use App\DoTheSums\Shared\Domain\Entity\UserAccount;
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
class Household
{
    #[Id]
    #[Column(type: 'ulid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private Ulid $ulid;

    #[Column(type: 'not_empty_name', nullable: false)]
    private NotEmptyName $name;

    /** @var Collection<int,Contributor> */
    #[OneToMany(mappedBy: 'household', targetEntity: Contributor::class, cascade: ['persist' => 'persist'])]
    private Collection $contributors;

    #[ManyToOne(targetEntity: UserAccount::class, inversedBy: 'households')]
    #[JoinColumn(name: 'creator_ulid', referencedColumnName: 'ulid', nullable: false)]
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

    public static function create(NotEmptyName $name, UserAccount $creator): self
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

    public function getCreator(): UserAccount
    {
        return $this->creator;
    }

    public function registerExpense(Ulid $contributorUlid, Amount $amount, NotEmptyName $description, \DateTimeImmutable $registeredAt): void
    {
        $contributor = $this->getContributor($contributorUlid);
        $contributor->registerNewExpense($amount, $description, $registeredAt);
    }

    public function addContributor(NotEmptyName $contributorName): void
    {
        $isContributorExists = $this->contributors->exists(
            static fn(int $key, Contributor $contributor): bool => $contributor->getName()->equals($contributorName)
        );

        if ($isContributorExists === true) {
            throw new \Exception('A contributor already exists with the same name');
        }

        $this->contributors->add(
            new Contributor($this, $contributorName)
        );
    }

    public function getTotalSpent(): Amount
    {
        return \array_reduce(
            $this->contributors->toArray(),
            static function (Amount $lastAmount, Contributor $contributor) {
                return Amount::fromFloat($lastAmount->getValue() + $contributor->getTotalSpent()->getValue());
            },
            Amount::fromFloat(0)
        );
    }

    private function getSupposedAmountSpentByContributor(): Amount
    {
        $totalSpent = $this->getTotalSpent();

        return Amount::fromFloat($totalSpent->getValue() / $this->contributors->count());
    }

    /**
     * @return array<Debtor>
     */
    public function getDebtors(): array
    {
        $supposedAmountSpentByContributor = $this->getSupposedAmountSpentByContributor();

        $debtors = [];
        foreach ($this->contributors as $contributor) {
            $balance = BalanceAmount::fromFloat($contributor->getTotalSpent()->getValue() - $supposedAmountSpentByContributor->getValue());

            if ($balance->isNegative() === true) {
                $debtors[] = new Debtor($contributor->getName(), $balance->toPositive());
            }
        }
        return $debtors;
    }

    /**
     * @return array<Creditor>
     */
    public function getCreditors(): array
    {
        $supposedAmountSpentByContributor = $this->getSupposedAmountSpentByContributor();

        $creditors = [];
        foreach ($this->contributors as $contributor) {
            $balance = BalanceAmount::fromFloat($contributor->getTotalSpent()->getValue() - $supposedAmountSpentByContributor->getValue());

            if ($balance->isPositive() === true) {
                $creditors[] = new Creditor($contributor->getName(), $balance->toPositive());
            }
        }
        return $creditors;
    }

    private function getContributor(Ulid $contributorUlid): Contributor
    {
        $results = $this->contributors->filter(
            static fn(Contributor $contributor): bool => $contributor->getUlid()->equals($contributorUlid)
        );

        if ($results->first() instanceof Contributor === false) {
            throw new \Exception('Contributor does not exist in this household');
        }

        return $results->first();
    }

    public function getBalance(): array
    {
        $totalSpent = $this->getTotalSpent();

        $supposedAmountSpentByContributor = Amount::fromFloat($totalSpent->getValue() / $this->contributors->count());

        $balance = [];

        foreach ($this->contributors as $contributor) {
            $balance[] = [
                'contributor' => $contributor->getName(),
                'balance' => BalanceAmount::fromFloat($supposedAmountSpentByContributor->getValue() - $contributor->getTotalSpent()->getValue()),
            ];
        }
        return $balance;
    }
}

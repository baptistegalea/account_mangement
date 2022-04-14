<?php

declare(strict_types=1);

namespace App\DoTheSums\Shared\Domain\Entity;

use App\DoTheSums\Household\Shared\Domain\Entity\Household;
use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use App\DoTheSums\UserAccount\Shared\Domain\Entity\UserAccountCreationRequest;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Email;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Salt;
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
class UserAccount
{
    #[Id]
    #[Column(type: 'ulid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private Ulid $ulid;

    #[Column(type: 'email', unique: true, nullable: false)]
    private Email $email;

    #[Column(type: 'text', nullable: false)]
    private string $hashedPassword;

    #[Column(type: 'salt', nullable: false)]
    private Salt $salt;

    #[Column(type: 'not_empty_name', nullable: false)]
    private NotEmptyName $name;

    #[Column(type: 'datetime', nullable: false)]
    private \DateTime $registeredAt;

    /** @var Collection<int,Household> */
    #[OneToMany(mappedBy: 'creator', targetEntity: Household::class, cascade: ['persist' => 'persist'])]
    private Collection $households;

    private function __construct(Email $email, string $hashedPassword, Salt $salt, NotEmptyName $name, \DateTimeImmutable $registeredAt)
    {
        $this->ulid = new Ulid();
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->name = $name;
        $this->registeredAt = \DateTime::createFromImmutable($registeredAt);
        $this->salt = $salt;
        $this->households = new ArrayCollection();
    }

    public static function fromUserAccountCreationRequest(UserAccountCreationRequest $accountCreationRequest, \DateTimeImmutable $registeredAt): self
    {
        return new self($accountCreationRequest->getEmail(), $accountCreationRequest->getHashedPassword(), $accountCreationRequest->getSalt(), $accountCreationRequest->getName(), $registeredAt);
    }

    public function createNewHousehold(NotEmptyName $householdName): void
    {
        $this->households->add(Household::create($householdName, $this));
    }

    public function getUlid(): Ulid
    {
        return $this->ulid;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function getSalt(): Salt
    {
        return $this->salt;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getName(): NotEmptyName
    {
        return $this->name;
    }

    public function getRegisteredAt(): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromMutable($this->registeredAt);
    }

    /**
     * @return array<Household>
     */
    public function getHouseholds(): array
    {
        return $this->households->toArray();
    }
}

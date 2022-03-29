<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Domain\Entity;

use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Email;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Uid\Ulid;

#[Entity]
class UserAccount
{
    #[Id]
    #[Column(type: 'ulid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private Ulid $ulid;

    #[Column(type: "email", unique: true, nullable: false)]
    private Email $email;

    #[Column(type: "text", nullable: false)]
    private string $hashedPassword;

    #[Column(type: "not_empty_name", nullable: false)]
    private NotEmptyName $name;

    #[Column(type: "datetime", nullable: false)]
    private \DateTime $registeredAt;

    private function __construct(Email $email, string $hashedPassword, NotEmptyName $name, \DateTimeImmutable $registeredAt)
    {
        $this->ulid = new Ulid();
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->name = $name;
        $this->registeredAt = \DateTime::createFromImmutable($registeredAt);
    }

    public static function fromUserAccountCreationRequest(UserAccountCreationRequest $accountCreationRequest, \DateTimeImmutable $registeredAt): self
    {
        return new self($accountCreationRequest->getEmail(), $accountCreationRequest->getHashedPassword(), $accountCreationRequest->getName(), $registeredAt);
    }
}

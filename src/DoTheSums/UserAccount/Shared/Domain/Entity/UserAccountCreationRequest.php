<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Domain\Entity;

use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Email;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\HashedPassword;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\OneTimePassword;
use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Salt;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Uid\Ulid;

#[Entity]
class UserAccountCreationRequest
{
    #[Id]
    #[Column(type: 'ulid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private Ulid $ulid;

    #[Column(type: "email", nullable: false)]
    private Email $email;

    #[Column(type: "text", nullable: false)]
    private string $hashedPassword;

    #[Column(type: "salt", nullable: false)]
    private Salt $salt;

    #[Column(type: "not_empty_name", nullable: false)]
    private NotEmptyName $name;

    #[Column(type: "one_time_password", nullable: false)]
    private OneTimePassword $oneTimePassword;

    #[Column(type: "datetime", nullable: false)]
    private \DateTime $requestedAt;

    public function __construct(Email $email, HashedPassword $hashedPassword, NotEmptyName $name, OneTimePassword $oneTimePassword, \DateTimeImmutable $requestedAt)
    {
        $this->ulid = new Ulid();
        $this->email = $email;
        $this->hashedPassword = $hashedPassword->getHashedPassword();
        $this->salt = $hashedPassword->getSalt();
        $this->name = $name;
        $this->oneTimePassword = OneTimePassword::create();
        $this->requestedAt = \DateTime::createFromImmutable($requestedAt);
        $this->oneTimePassword = $oneTimePassword;
    }

    public function getUlid(): Ulid
    {
        return $this->ulid;
    }

    public function getOneTimePassword(): OneTimePassword
    {
        return $this->oneTimePassword;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function getSalt(): Salt
    {
        return $this->salt;
    }

    public function getRequestedAt(): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromMutable($this->requestedAt);
    }

    public function getName(): NotEmptyName
    {
        return $this->name;
    }
}

<?php
declare(strict_types=1);

namespace App\Domain\Entity;

//use Doctrine\ORM\Mapping\Column;
//use Doctrine\ORM\Mapping\CustomIdGenerator;
//use Doctrine\ORM\Mapping\Entity;
//use Doctrine\ORM\Mapping\GeneratedValue;
//use Doctrine\ORM\Mapping\Id;
//use Doctrine\ORM\Mapping\ManyToOne;
//use Symfony\Component\Uid\Ulid;
//
//#[Entity]
class Expense
{
//    #[Id]
//    #[Column(type: 'ulid', unique: true)]
//    #[GeneratedValue(strategy: 'CUSTOM')]
//    #[CustomIdGenerator(class: 'doctrine.ulid_generator')]
//    private Ulid $ulid;
//
//    #[Column(type: "int", nullable: false)]
//    private int $amount;
//
//    #[ManyToOne(targetEntity: "User")]
//    private User $payer;
//
//    public function __construct(User $payer, int $amount)
//    {
//        $this->ulid = new Ulid();
//        $this->payer = $payer;
//        $this->amount = $amount;
//    }
//
//    public function getUlid(): Ulid
//    {
//        return $this->ulid;
//    }
//
//    public function getAmount(): int
//    {
//        return $this->amount;
//    }
//
//    public function getPayer(): User
//    {
//        return $this->payer;
//    }
}

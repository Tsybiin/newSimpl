<?php

namespace App\Entity;

use App\Repository\KeyVpnRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KeyVpnRepository::class)]
class KeyVpn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $ID = null;

    #[ORM\Column(length: 255)]
    private ?string $NAME = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DATE_SEND = null;

    public function getId(): ?int
    {
        return $this->ID;
    }
    public function getNAME(): ?string
    {
        return $this->NAME;
    }

    public function setNAME(string $NAME): static
    {
        $this->NAME = $NAME;

        return $this;
    }

    public function getDATESEND(): ?\DateTimeInterface
    {
        return $this->DATE_SEND;
    }
    public function setDATESEND(): static
    {
        $dataNow =  new \DateTime();
        $this->DATE_SEND = $dataNow->setTimezone(new \DateTimeZone('Europe/Moscow'));
        return $this;
    }
}

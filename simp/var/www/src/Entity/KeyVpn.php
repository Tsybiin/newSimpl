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
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $id_user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_send = null;

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser($idUser): static
    {
        $this->id_user = $idUser;
        return $this;

    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDateSend(): ?\DateTimeInterface
    {
        return $this->date_send;
    }

    public function setDateSend(): static
    {
        $dataNow = new \DateTime();
        $this->date_send = $dataNow->setTimezone(new \DateTimeZone('Europe/Moscow'));
        return $this;
    }
}

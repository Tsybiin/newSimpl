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

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?int $id_user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_send = null;

    public function setIdUser($idUser): ?int
    {
        $this->id_user = $idUser;
        return $this->id_user;
    }

    public function getIdUser(): ?string
    {
        return $this->id_user;
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

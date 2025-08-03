<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class UserTG
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $id_telegram = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column]
    private ?int $id_open_vpn_key = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_register = null;
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $auth_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTelegram(): ?string
    {
        return $this->id_telegram;
    }

    public function setIdTelegram(string $id_telegram): static
    {
        $this->id_telegram = $id_telegram;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getIdOpenVpnKey(): ?int
    {
        return $this->id_open_vpn_key;
    }

    public function setIdOpenVpnKey(int $id_open_vpn_key): static
    {
        $this->id_open_vpn_key = $id_open_vpn_key;

        return $this;
    }

    public function getDateRegister(): ?\DateTimeInterface
    {
        return $this->date_register;
    }

    public function setDateRegister(): static
    {
        $dataNow =  new \DateTime();
        $this->date_register = $dataNow->setTimezone(new \DateTimeZone('Europe/Moscow'));
        return $this;

    }
    public function setAuthDate(): static
    {
        $dataNow =  new \DateTime();
        $this->auth_date = $dataNow->setTimezone(new \DateTimeZone('Europe/Moscow'));
        return $this;

    }
}

<?php

namespace App\Entity;

use App\Repository\OpenVpnStatusRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpenVpnStatusRepository::class)]
class OpenVpnStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ip = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $bytes_received = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?float $bytes_sent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    public \DateTimeInterface $connected_since;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_update = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): static
    {
         $this->id = $id;
         return $this;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): static
    {
        $this->ip = $ip;

        return $this;
    }

    public function getBytesReceived(): ?string
    {
        return $this->bytes_received;
    }

    public function setBytesReceived(?string $bytes_received,$convert = true): static
    {
        $this->bytes_received = $convert ? $this->convertToReadableSize($bytes_received):$bytes_received;

        return $this;
    }

    public function getBytesSent(): ?string
    {
        return $this->bytes_sent;
    }

    public function setBytesSent(?string $bytes_sent, $convert = true): static
    {
        $this->bytes_sent = $convert ? $this->convertToReadableSize($bytes_sent) : $bytes_sent;
        return $this;
    }

    public function getConnectedSince(): \DateTime
    {
        return $this->connected_since;
    }

    public function setConnectedSince(?string $connected_since): static
    {
        $obDataNow =  new \DateTime($connected_since);
        $this->connected_since = $obDataNow;
        return $this;
    }

    private function convertToReadableSize($bytes)
    {
        $bytes = $bytes / 1024 / 1024;
        return round($bytes, 2);


        // $symbols = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        // $exp = floor(log($bytes)/log(1024));
        // return sprintf('%.2f '.$symbols[$exp], ($bytes/pow(1024, floor($exp))));
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->date_update;
    }

    public function setDateUpdate(): static
    {
        $obDataNow =  new \DateTime();
        $this->date_update = $obDataNow;

        return $this;
    }
}

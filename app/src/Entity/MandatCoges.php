<?php

namespace App\Entity;

use App\Repository\MandatCogesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MandatCogesRepository::class)]
class MandatCoges
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateFin = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?COGES $IDCoges = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): static
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): static
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getIDCoges(): ?COGES
    {
        return $this->IDCoges;
    }

    public function setIDCoges(?COGES $IDCoges): static
    {
        $this->IDCoges = $IDCoges;

        return $this;
    }
}

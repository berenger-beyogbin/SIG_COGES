<?php

namespace App\Entity;

use App\Repository\PaccRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaccRepository::class)]
class Pacc
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
    private ?MandatCoges $IDMandat = null;

    #[ORM\Column(length: 255)]
    private ?string $CheminFichier = null;

    #[ORM\Column(length: 255)]
    private ?string $NomFichier = null;

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

    public function getIDMandat(): ?MandatCoges
    {
        return $this->IDMandat;
    }

    public function setIDMandat(?MandatCoges $IDMandat): static
    {
        $this->IDMandat = $IDMandat;

        return $this;
    }

    public function getCheminFichier(): ?string
    {
        return $this->CheminFichier;
    }

    public function setCheminFichier(string $CheminFichier): static
    {
        $this->CheminFichier = $CheminFichier;

        return $this;
    }

    public function getNomFichier(): ?string
    {
        return $this->NomFichier;
    }

    public function setNomFichier(string $NomFichier): static
    {
        $this->NomFichier = $NomFichier;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EtablissementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtablissementRepository::class)]
#[ApiResource]
class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Localite = null;

    #[ORM\Column(length: 50)]
    private ?string $TypeMilieu = null;

    #[ORM\Column(length: 50)]
    private ?string $Cycle = null;

    #[ORM\Column(length: 10)]
    private ?string $CodeEts = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dren $IDDren = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Iepp $IDIepp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getLocalite(): ?string
    {
        return $this->Localite;
    }

    public function setLocalite(string $Localite): static
    {
        $this->Localite = $Localite;

        return $this;
    }

    public function getTypeMilieu(): ?string
    {
        return $this->TypeMilieu;
    }

    public function setTypeMilieu(string $TypeMilieu): static
    {
        $this->TypeMilieu = $TypeMilieu;

        return $this;
    }

    public function getCycle(): ?string
    {
        return $this->Cycle;
    }

    public function setCycle(string $Cycle): static
    {
        $this->Cycle = $Cycle;

        return $this;
    }

    public function getCodeEts(): ?string
    {
        return $this->CodeEts;
    }

    public function setCodeEts(string $CodeEts): static
    {
        $this->CodeEts = $CodeEts;

        return $this;
    }

    public function getIDDren(): ?Dren
    {
        return $this->IDDren;
    }

    public function setIDDren(?Dren $IDDren): static
    {
        $this->IDDren = $IDDren;

        return $this;
    }

    public function getIDIepp(): ?Iepp
    {
        return $this->IDIepp;
    }

    public function setIDIepp(?Iepp $IDIepp): static
    {
        $this->IDIepp = $IDIepp;

        return $this;
    }
}

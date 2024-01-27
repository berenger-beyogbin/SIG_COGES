<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\COGESRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: COGESRepository::class)]
#[ApiResource]
class COGES
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $LibelleCOGES = null;

    #[ORM\Column]
    private ?int $Cycle = null;

    #[ORM\Column(length: 24)]
    private ?string $NumeroCompte = null;

    #[ORM\Column(length: 100)]
    private ?string $Domiciliation = null;

    #[ORM\Column(length: 100)]
    private ?string $ListeETS = null;

    #[ORM\ManyToOne(inversedBy: 'Coges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dren $IDDren = null;

    #[ORM\ManyToOne(inversedBy: 'Coges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Iepp $IDIEpp = null;

    #[ORM\Column]
    private ?bool $GroupeScolaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCOGES(): ?string
    {
        return $this->LibelleCOGES;
    }

    public function setLibelleCOGES(string $LibelleCOGES): static
    {
        $this->LibelleCOGES = $LibelleCOGES;

        return $this;
    }

    public function getCycle(): ?int
    {
        return $this->Cycle;
    }

    public function setCycle(int $Cycle): static
    {
        $this->Cycle = $Cycle;

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->NumeroCompte;
    }

    public function setNumeroCompte(string $NumeroCompte): static
    {
        $this->NumeroCompte = $NumeroCompte;

        return $this;
    }

    public function getDomiciliation(): ?string
    {
        return $this->Domiciliation;
    }

    public function setDomiciliation(string $Domiciliation): static
    {
        $this->Domiciliation = $Domiciliation;

        return $this;
    }

    public function getListeETS(): ?string
    {
        return $this->ListeETS;
    }

    public function setListeETS(string $ListeETS): static
    {
        $this->ListeETS = $ListeETS;

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

    public function getIDIEpp(): ?Iepp
    {
        return $this->IDIEpp;
    }

    public function setIDIEpp(?Iepp $IDIEpp): static
    {
        $this->IDIEpp = $IDIEpp;

        return $this;
    }

    public function isGroupeScolaire(): ?bool
    {
        return $this->GroupeScolaire;
    }

    public function setGroupeScolaire(bool $GroupeScolaire): static
    {
        $this->GroupeScolaire = $GroupeScolaire;

        return $this;
    }
}

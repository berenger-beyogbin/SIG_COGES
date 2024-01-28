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
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $localite = null;

    #[ORM\Column(length: 50)]
    private ?string $typeMilieu = null;

    #[ORM\Column(length: 50)]
    private ?string $cycle = null;

    #[ORM\Column(length: 10)]
    private ?string $codeEts = null;

    #[ORM\ManyToOne(inversedBy: 'etablissements')]
    private ?Iepp $iepp = null;

    #[ORM\ManyToOne(inversedBy: 'etablissements')]
    private ?Dren $dren = null;

    #[ORM\ManyToOne(inversedBy: 'etablissements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Coges $coges = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLocalite(): ?string
    {
        return $this->localite;
    }

    public function setLocalite(string $localite): static
    {
        $this->localite = $localite;

        return $this;
    }

    public function getTypeMilieu(): ?string
    {
        return $this->typeMilieu;
    }

    public function setTypeMilieu(string $typeMilieu): static
    {
        $this->typeMilieu = $typeMilieu;

        return $this;
    }

    public function getCycle(): ?string
    {
        return $this->cycle;
    }

    public function setCycle(string $cycle): static
    {
        $this->cycle = $cycle;

        return $this;
    }

    public function getCodeEts(): ?string
    {
        return $this->codeEts;
    }

    public function setCodeEts(string $codeEts): static
    {
        $this->codeEts = $codeEts;

        return $this;
    }

    public function getIepp(): ?Iepp
    {
        return $this->iepp;
    }

    public function setIepp(?Iepp $iepp): static
    {
        $this->iepp = $iepp;

        return $this;
    }

    public function getDren(): ?Dren
    {
        return $this->dren;
    }

    public function setDren(?Dren $dren): static
    {
        $this->dren = $dren;

        return $this;
    }

    public function getCoges(): ?Coges
    {
        return $this->coges;
    }

    public function setCoges(?Coges $coges): static
    {
        $this->coges = $coges;

        return $this;
    }


}

<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
class Activite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $libelleActivite = null;

    #[ORM\ManyToOne(inversedBy: 'activites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chapitre $chapitre = null;

    #[ORM\ManyToOne(inversedBy: 'activites')]
    private ?Fournisseur $fournisseur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleActivite(): ?string
    {
        return $this->libelleActivite;
    }

    public function setLibelleActivite(string $libelleActivite): static
    {
        $this->libelleActivite = $libelleActivite;

        return $this;
    }

    public function getChapitre(): ?Chapitre
    {
        return $this->chapitre;
    }

    public function setChapitre(?Chapitre $chapitre): static
    {
        $this->chapitre = $chapitre;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

}

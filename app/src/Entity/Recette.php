<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montantRecette = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Source $source = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pacc $pacc = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantRecette(): ?int
    {
        return $this->montantRecette;
    }

    public function setMontantRecette(int $montantRecette): static
    {
        $this->montantRecette = $montantRecette;

        return $this;
    }

    public function getSource(): ?Source
    {
        return $this->source;
    }

    public function setSource(?Source $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getPacc(): ?Pacc
    {
        return $this->pacc;
    }

    public function setPacc(?Pacc $pacc): static
    {
        $this->pacc = $pacc;

        return $this;
    }

}

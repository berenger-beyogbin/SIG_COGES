<?php

namespace App\Entity;

use App\Repository\ActivitesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivitesRepository::class)]
class Activites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $LibelleActivite = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chapitres $IDChapitre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleActivite(): ?string
    {
        return $this->LibelleActivite;
    }

    public function setLibelleActivite(string $LibelleActivite): static
    {
        $this->LibelleActivite = $LibelleActivite;

        return $this;
    }

    public function getIDChapitre(): ?Chapitres
    {
        return $this->IDChapitre;
    }

    public function setIDChapitre(?Chapitres $IDChapitre): static
    {
        $this->IDChapitre = $IDChapitre;

        return $this;
    }
}

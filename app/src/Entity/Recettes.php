<?php

namespace App\Entity;

use App\Repository\RecettesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecettesRepository::class)]
class Recettes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $MontantRecettes = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pacc $IDPacc = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sources $IDSources = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantRecettes(): ?int
    {
        return $this->MontantRecettes;
    }

    public function setMontantRecettes(int $MontantRecettes): static
    {
        $this->MontantRecettes = $MontantRecettes;

        return $this;
    }

    public function getIDPacc(): ?Pacc
    {
        return $this->IDPacc;
    }

    public function setIDPacc(?Pacc $IDPacc): static
    {
        $this->IDPacc = $IDPacc;

        return $this;
    }

    public function getIDSources(): ?Sources
    {
        return $this->IDSources;
    }

    public function setIDSources(?Sources $IDSources): static
    {
        $this->IDSources = $IDSources;

        return $this;
    }
}

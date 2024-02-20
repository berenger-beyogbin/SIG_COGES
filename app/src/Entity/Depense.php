<?php

namespace App\Entity;

use App\Repository\DepenseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepenseRepository::class)]
class Depense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column()]
    private ?int $montantDepense = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fichierPreuve = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomFichierPreuve = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateExe = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heureExe = null;

    #[ORM\Column]
    private ?bool $paiementFournisseur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activite $activite = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pacc $pacc = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantDepense(): ?int
    {
        return $this->montantDepense;
    }

    public function setMontantDepense(int $montantDepense): static
    {
        $this->montantDepense = $montantDepense;

        return $this;
    }

    public function getFichierPreuve(): ?string
    {
        return $this->fichierPreuve;
    }

    public function setFichierPreuve(?string $fichierPreuve): static
    {
        $this->fichierPreuve = $fichierPreuve;

        return $this;
    }

    public function getNomFichierPreuve(): ?string
    {
        return $this->nomFichierPreuve;
    }

    public function setNomFichierPreuve(?string $nomFichierPreuve): static
    {
        $this->nomFichierPreuve = $nomFichierPreuve;

        return $this;
    }

    public function getDateExe(): ?\DateTimeInterface
    {
        return $this->dateExe;
    }

    public function setDateExe(?\DateTimeInterface $dateExe): static
    {
        $this->dateExe = $dateExe;

        return $this;
    }

    public function getHeureExe(): ?\DateTimeInterface
    {
        return $this->heureExe;
    }

    public function setHeureExe(?\DateTimeInterface $heureExe): static
    {
        $this->heureExe = $heureExe;

        return $this;
    }

    public function isPaiementFournisseur(): ?bool
    {
        return $this->paiementFournisseur;
    }

    public function setPaiementFournisseur(bool $paiementFournisseur): static
    {
        $this->paiementFournisseur = $paiementFournisseur;

        return $this;
    }


    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): static
    {
        $this->activite = $activite;

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

<?php

namespace App\Entity;

use App\Repository\DepensesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepensesRepository::class)]
class Depenses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $MontantDepense = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chapitres $IDChapitre = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activites $IDActivites = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pacc $IDPacc = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $FichierPreuve = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $NomFichierPreuve = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateExe = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $HeureExe = null;

    #[ORM\Column]
    private ?bool $PaiementFournisseur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantDepense(): ?int
    {
        return $this->MontantDepense;
    }

    public function setMontantDepense(int $MontantDepense): static
    {
        $this->MontantDepense = $MontantDepense;

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

    public function getIDActivites(): ?Activites
    {
        return $this->IDActivites;
    }

    public function setIDActivites(?Activites $IDActivites): static
    {
        $this->IDActivites = $IDActivites;

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

    public function getFichierPreuve(): ?string
    {
        return $this->FichierPreuve;
    }

    public function setFichierPreuve(?string $FichierPreuve): static
    {
        $this->FichierPreuve = $FichierPreuve;

        return $this;
    }

    public function getNomFichierPreuve(): ?string
    {
        return $this->NomFichierPreuve;
    }

    public function setNomFichierPreuve(?string $NomFichierPreuve): static
    {
        $this->NomFichierPreuve = $NomFichierPreuve;

        return $this;
    }

    public function getDateExe(): ?\DateTimeInterface
    {
        return $this->DateExe;
    }

    public function setDateExe(?\DateTimeInterface $DateExe): static
    {
        $this->DateExe = $DateExe;

        return $this;
    }

    public function getHeureExe(): ?\DateTimeInterface
    {
        return $this->HeureExe;
    }

    public function setHeureExe(?\DateTimeInterface $HeureExe): static
    {
        $this->HeureExe = $HeureExe;

        return $this;
    }

    public function isPaiementFournisseur(): ?bool
    {
        return $this->PaiementFournisseur;
    }

    public function setPaiementFournisseur(bool $PaiementFournisseur): static
    {
        $this->PaiementFournisseur = $PaiementFournisseur;

        return $this;
    }
}

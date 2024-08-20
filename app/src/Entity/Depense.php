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
    private ?\DateTimeInterface $dateExecution = null;

    #[ORM\Column(type:'boolean', nullable: true)]
    private ?bool $paiementFournisseur = null;

    #[ORM\Column(type:'boolean', nullable: true)]
    private ?bool $statut = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activite $activite = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pacc $pacc = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Fournisseur $fournisseur = null;

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

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateExecution(): ?\DateTimeInterface
    {
        return $this->dateExecution;
    }

    /**
     * @param \DateTimeInterface|null $dateExecution
     * @return Depense
     */
    public function setDateExecution(?\DateTimeInterface $dateExecution): Depense
    {
        $this->dateExecution = $dateExecution;
        return $this;
    }


    public function isPaiementFournisseur(): ?bool
    {
        return $this->paiementFournisseur;
    }

    public function setPaiementFournisseur(?bool $paiementFournisseur): static
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

    /**
     * @return bool|null
     */
    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    /**
     * @param bool|null $statut
     * @return Depense
     */
    public function setStatut(?bool $statut): Depense
    {
        $this->statut = $statut;
        return $this;
    }

    /**
     * @return Fournisseur|null
     */
    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    /**
     * @param Fournisseur|null $fournisseur
     * @return Depense
     */
    public function setFournisseur(?Fournisseur $fournisseur): Depense
    {
        $this->fournisseur = $fournisseur;
        return $this;
    }


}

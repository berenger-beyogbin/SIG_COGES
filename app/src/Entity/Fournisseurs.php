<?php

namespace App\Entity;

use App\Repository\FournisseursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseursRepository::class)]
class Fournisseurs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomPrenoms = null;

    #[ORM\Column(length: 50)]
    private ?string $Contact = null;

    #[ORM\Column(length: 100)]
    private ?string $Entreprise = null;

    #[ORM\Column(length: 100)]
    private ?string $Activite = null;

    #[ORM\Column(length: 100)]
    private ?string $Localite = null;

    #[ORM\Column(length: 24)]
    private ?string $RIB = null;

    #[ORM\Column(length: 100)]
    private ?string $Domiciliation = null;

    #[ORM\Column(length: 255)]
    private ?string $IntituleCompte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrenoms(): ?string
    {
        return $this->NomPrenoms;
    }

    public function setNomPrenoms(string $NomPrenoms): static
    {
        $this->NomPrenoms = $NomPrenoms;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->Contact;
    }

    public function setContact(string $Contact): static
    {
        $this->Contact = $Contact;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->Entreprise;
    }

    public function setEntreprise(string $Entreprise): static
    {
        $this->Entreprise = $Entreprise;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->Activite;
    }

    public function setActivite(string $Activite): static
    {
        $this->Activite = $Activite;

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

    public function getRIB(): ?string
    {
        return $this->RIB;
    }

    public function setRIB(string $RIB): static
    {
        $this->RIB = $RIB;

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

    public function getIntituleCompte(): ?string
    {
        return $this->IntituleCompte;
    }

    public function setIntituleCompte(string $IntituleCompte): static
    {
        $this->IntituleCompte = $IntituleCompte;

        return $this;
    }
}

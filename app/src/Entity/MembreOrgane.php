<?php

namespace App\Entity;

use App\Repository\MembreOrganeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreOrganeRepository::class)]
class MembreOrgane
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomPrenoms = null;

    #[ORM\Column(length: 10)]
    private ?string $Genre = null;

    #[ORM\Column(length: 50)]
    private ?string $Profession = null;

    #[ORM\Column(length: 50)]
    private ?string $Contact = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrganeCoges $IDOrgane = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PosteOrgane $IDPoste = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MandatCoges $IDMandat = null;

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

    public function getGenre(): ?string
    {
        return $this->Genre;
    }

    public function setGenre(string $Genre): static
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->Profession;
    }

    public function setProfession(string $Profession): static
    {
        $this->Profession = $Profession;

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

    public function getIDOrgane(): ?OrganeCoges
    {
        return $this->IDOrgane;
    }

    public function setIDOrgane(?OrganeCoges $IDOrgane): static
    {
        $this->IDOrgane = $IDOrgane;

        return $this;
    }

    public function getIDPoste(): ?PosteOrgane
    {
        return $this->IDPoste;
    }

    public function setIDPoste(?PosteOrgane $IDPoste): static
    {
        $this->IDPoste = $IDPoste;

        return $this;
    }

    public function getIDMandat(): ?MandatCoges
    {
        return $this->IDMandat;
    }

    public function setIDMandat(?MandatCoges $IDMandat): static
    {
        $this->IDMandat = $IDMandat;

        return $this;
    }
}

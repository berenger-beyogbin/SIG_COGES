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
    private ?string $nom= null;
    private ?string $prenoms = null;

    #[ORM\Column(length: 10)]
    private ?string $genre = null;

    #[ORM\Column(length: 50)]
    private ?string $profession = null;

    #[ORM\Column(length: 50)]
    private ?string $contact = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PosteOrgane $poste = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MandatCoges $mandat = null;

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

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): static
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getPoste(): ?PosteOrgane
    {
        return $this->poste;
    }

    public function setPoste(PosteOrgane $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getMandat(): ?MandatCoges
    {
        return $this->mandat;
    }

    public function setMandat(MandatCoges $mandat): static
    {
        $this->mandat = $mandat;

        return $this;
    }

}

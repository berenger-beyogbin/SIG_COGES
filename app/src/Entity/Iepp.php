<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\IeppRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IeppRepository::class)]
#[ApiResource]
class Iepp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $parent = null;

    #[ORM\ManyToOne(inversedBy: 'iepps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dren $IDDren = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getParent(): ?int
    {
        return $this->parent;
    }

    public function setParent(int $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    public function getIDDren(): ?Dren
    {
        return $this->IDDren;
    }

    public function setIDDren(?Dren $IDDren): static
    {
        $this->IDDren = $IDDren;

        return $this;
    }
}

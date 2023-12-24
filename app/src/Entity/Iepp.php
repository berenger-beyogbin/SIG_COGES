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
}

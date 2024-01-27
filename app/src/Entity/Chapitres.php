<?php

namespace App\Entity;

use App\Repository\ChapitresRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChapitresRepository::class)]
class Chapitres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $LibelleChapitre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleChapitre(): ?string
    {
        return $this->LibelleChapitre;
    }

    public function setLibelleChapitre(string $LibelleChapitre): static
    {
        $this->LibelleChapitre = $LibelleChapitre;

        return $this;
    }
}

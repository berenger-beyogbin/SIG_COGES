<?php

namespace App\Entity;

use App\Repository\SourceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
class Source
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelleSource = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleSource(): ?string
    {
        return $this->libelleSource;
    }

    public function setLibelleSource(string $libelleSource): static
    {
        $this->libelleSource = $libelleSource;

        return $this;
    }
}

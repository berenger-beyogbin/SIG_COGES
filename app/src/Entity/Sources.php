<?php

namespace App\Entity;

use App\Repository\SourcesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SourcesRepository::class)]
class Sources
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $LibelleSources = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleSources(): ?string
    {
        return $this->LibelleSources;
    }

    public function setLibelleSources(string $LibelleSources): static
    {
        $this->LibelleSources = $LibelleSources;

        return $this;
    }
}

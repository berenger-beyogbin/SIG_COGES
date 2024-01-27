<?php

namespace App\Entity;

use App\Repository\PosteOrganeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PosteOrganeRepository::class)]
class PosteOrgane
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $LibellePoste = null;

    #[ORM\ManyToOne(inversedBy: 'Poste')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrganeCoges $IDOrgane = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibellePoste(): ?string
    {
        return $this->LibellePoste;
    }

    public function setLibellePoste(string $LibellePoste): static
    {
        $this->LibellePoste = $LibellePoste;

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
}

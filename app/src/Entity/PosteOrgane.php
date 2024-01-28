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
    private ?string $libellePoste = null;

    #[ORM\ManyToOne(inversedBy: 'postes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrganeCoges $organeCoges = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibellePoste(): ?string
    {
        return $this->libellePoste;
    }

    public function setLibellePoste(string $libellePoste): static
    {
        $this->libellePoste = $libellePoste;

        return $this;
    }

    public function getOrganeCoges(): ?OrganeCoges
    {
        return $this->organeCoges;
    }

    public function setOrganeCoges(?OrganeCoges $organeCoges): static
    {
        $this->organeCoges = $organeCoges;

        return $this;
    }

}

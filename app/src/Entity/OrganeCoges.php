<?php

namespace App\Entity;

use App\Repository\OrganeCogesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganeCogesRepository::class)]
class OrganeCoges
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $LibelleOrgane = null;

    #[ORM\OneToMany(mappedBy: 'IDOrgane', targetEntity: PosteOrgane::class)]
    private Collection $Poste;

    public function __construct()
    {
        $this->Poste = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleOrgane(): ?string
    {
        return $this->LibelleOrgane;
    }

    public function setLibelleOrgane(string $LibelleOrgane): static
    {
        $this->LibelleOrgane = $LibelleOrgane;

        return $this;
    }

    /**
     * @return Collection<int, PosteOrgane>
     */
    public function getPoste(): Collection
    {
        return $this->Poste;
    }

    public function addPoste(PosteOrgane $poste): static
    {
        if (!$this->Poste->contains($poste)) {
            $this->Poste->add($poste);
            $poste->setIDOrgane($this);
        }

        return $this;
    }

    public function removePoste(PosteOrgane $poste): static
    {
        if ($this->Poste->removeElement($poste)) {
            // set the owning side to null (unless already changed)
            if ($poste->getIDOrgane() === $this) {
                $poste->setIDOrgane(null);
            }
        }

        return $this;
    }
}

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
    private ?string $libelleOrgane = null;

    #[ORM\OneToMany(mappedBy: 'organeCoges', targetEntity: PosteOrgane::class)]
    private Collection $postes;



    public function __construct()
    {
        $this->postes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleOrgane(): ?string
    {
        return $this->libelleOrgane;
    }

    public function setLibelleOrgane(string $libelleOrgane): static
    {
        $this->libelleOrgane = $libelleOrgane;

        return $this;
    }

    /**
     * @return Collection<int, PosteOrgane>
     */
    public function getPostes(): Collection
    {
        return $this->postes;
    }

    public function addPoste(PosteOrgane $poste): static
    {
        if (!$this->postes->contains($poste)) {
            $this->postes->add($poste);
            $poste->setOrganeCoges($this);
        }

        return $this;
    }

    public function removePoste(PosteOrgane $poste): static
    {
        if ($this->postes->removeElement($poste)) {
            // set the owning side to null (unless already changed)
            if ($poste->getOrganeCoges() === $this) {
                $poste->setOrganeCoges(null);
            }
        }

        return $this;
    }

}

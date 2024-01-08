<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DrenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DrenRepository::class)]
#[ApiResource]
class Dren
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'IDDren', targetEntity: Iepp::class)]
    private Collection $iepps;

    public function __construct()
    {
        $this->iepps = new ArrayCollection();
    }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Iepp>
     */
    public function getIepps(): Collection
    {
        return $this->iepps;
    }

    public function addIepp(Iepp $iepp): static
    {
        if (!$this->iepps->contains($iepp)) {
            $this->iepps->add($iepp);
            $iepp->setIDDren($this);
        }

        return $this;
    }

    public function removeIepp(Iepp $iepp): static
    {
        if ($this->iepps->removeElement($iepp)) {
            // set the owning side to null (unless already changed)
            if ($iepp->getIDDren() === $this) {
                $iepp->setIDDren(null);
            }
        }

        return $this;
    }
}

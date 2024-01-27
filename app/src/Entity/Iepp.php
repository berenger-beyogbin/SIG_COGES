<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\IeppRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'IDIEpp', targetEntity: COGES::class)]
    private Collection $Coges;

    public function __construct()
    {
        $this->Coges = new ArrayCollection();
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

    /**
     * @return Collection<int, COGES>
     */
    public function getCoges(): Collection
    {
        return $this->Coges;
    }

    public function addCoge(COGES $coge): static
    {
        if (!$this->Coges->contains($coge)) {
            $this->Coges->add($coge);
            $coge->setIDIEpp($this);
        }

        return $this;
    }

    public function removeCoge(COGES $coge): static
    {
        if ($this->Coges->removeElement($coge)) {
            // set the owning side to null (unless already changed)
            if ($coge->getIDIEpp() === $this) {
                $coge->setIDIEpp(null);
            }
        }

        return $this;
    }
}

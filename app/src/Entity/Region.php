<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
#[ApiResource]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: Commune::class, orphanRemoval: true)]
    private Collection $communes;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: Coges::class)]
    private Collection $region_coges;

    public function __construct()
    {
        $this->communes = new ArrayCollection();
        $this->region_coges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Commune>
     */
    public function getCommunes(): Collection
    {
        return $this->communes;
    }

    public function addCommune(Commune $commune): static
    {
        if (!$this->communes->contains($commune)) {
            $this->communes->add($commune);
            $commune->setRegion($this);
        }

        return $this;
    }

    public function removeCommune(Commune $commune): static
    {
        if ($this->communes->removeElement($commune)) {
            // set the owning side to null (unless already changed)
            if ($commune->getRegion() === $this) {
                $commune->setRegion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Coges>
     */
    public function getRegionCoges(): Collection
    {
        return $this->region_coges;
    }

    public function addRegionCoge(Coges $regionCoge): static
    {
        if (!$this->region_coges->contains($regionCoge)) {
            $this->region_coges->add($regionCoge);
            $regionCoge->setRegion($this);
        }

        return $this;
    }

    public function removeRegionCoge(Coges $regionCoge): static
    {
        if ($this->region_coges->removeElement($regionCoge)) {
            // set the owning side to null (unless already changed)
            if ($regionCoge->getRegion() === $this) {
                $regionCoge->setRegion(null);
            }
        }

        return $this;
    }
}

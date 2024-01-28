<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CommuneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommuneRepository::class)]
#[ApiResource]
class Commune
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'communes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Region $region = null;

    #[ORM\OneToMany(mappedBy: 'commune', targetEntity: Coges::class)]
    private Collection $commune_coges;

    public function __construct()
    {
        $this->commune_coges = new ArrayCollection();
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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): static
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection<int, Coges>
     */
    public function getCommuneCoges(): Collection
    {
        return $this->commune_coges;
    }

    public function addCommuneCoge(Coges $communeCoge): static
    {
        if (!$this->commune_coges->contains($communeCoge)) {
            $this->commune_coges->add($communeCoge);
            $communeCoge->setCommune($this);
        }

        return $this;
    }

    public function removeCommuneCoge(Coges $communeCoge): static
    {
        if ($this->commune_coges->removeElement($communeCoge)) {
            // set the owning side to null (unless already changed)
            if ($communeCoge->getCommune() === $this) {
                $communeCoge->setCommune(null);
            }
        }

        return $this;
    }
}

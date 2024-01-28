<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CogesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CogesRepository::class)]
#[ApiResource]
class Coges
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $libelleCOGES = null;

    #[ORM\Column]
    private ?int $cycle = null;
    #[ORM\Column(length: 24)]
    private ?string $numeroCompte = null;

    #[ORM\Column(length: 100)]
    private ?string $domiciliation = null;

    #[ORM\Column]
    private ?bool $groupeScolaire = null;

    #[ORM\OneToMany(mappedBy: 'coges', targetEntity: Etablissement::class)]
    private Collection $etablissements;

    #[ORM\ManyToOne(inversedBy: 'iepp_coges')]
    private ?Iepp $iepp = null;

    #[ORM\ManyToOne(inversedBy: 'dren_coges')]
    private ?Dren $dren = null;

    #[ORM\ManyToOne(inversedBy: 'region_coges')]
    private ?Region $region = null;

    #[ORM\ManyToOne(inversedBy: 'commune_coges')]
    private ?Commune $commune = null;

    #[ORM\OneToMany(mappedBy: 'coges', targetEntity: MandatCoges::class)]
    private Collection $mandats;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
        $this->mandats = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCOGES(): ?string
    {
        return $this->libelleCOGES;
    }

    public function setLibelleCOGES(string $libelleCOGES): static
    {
        $this->libelleCOGES = $libelleCOGES;

        return $this;
    }

    public function getCycle(): ?int
    {
        return $this->cycle;
    }

    public function setCycle(int $cycle): static
    {
        $this->cycle = $cycle;

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): static
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getDomiciliation(): ?string
    {
        return $this->domiciliation;
    }

    public function setDomiciliation(string $domiciliation): static
    {
        $this->domiciliation = $domiciliation;

        return $this;
    }

    public function isGroupeScolaire(): ?bool
    {
        return $this->groupeScolaire;
    }

    public function setGroupeScolaire(bool $groupeScolaire): static
    {
        $this->groupeScolaire = $groupeScolaire;

        return $this;
    }

    /**
     * @return Collection<int, Etablissement>
     */
    public function getEtablissements(): Collection
    {
        return $this->etablissements;
    }

    public function addEtablissement(Etablissement $etablissement): static
    {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements->add($etablissement);
            $etablissement->setCoges($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissement $etablissement): static
    {
        if ($this->etablissements->removeElement($etablissement)) {
            // set the owning side to null (unless already changed)
            if ($etablissement->getCoges() === $this) {
                $etablissement->setCoges(null);
            }
        }

        return $this;
    }

    public function getIepp(): ?Iepp
    {
        return $this->iepp;
    }

    public function setIepp(?Iepp $iepp): static
    {
        $this->iepp = $iepp;

        return $this;
    }

    public function getDren(): ?Dren
    {
        return $this->dren;
    }

    public function setDren(?Dren $dren): static
    {
        $this->dren = $dren;

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

    public function getCommune(): ?Commune
    {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): static
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * @return Collection<int, MandatCoges>
     */
    public function getMandats(): Collection
    {
        return $this->mandats;
    }

    public function addMandat(MandatCoges $mandat): static
    {
        if (!$this->mandats->contains($mandat)) {
            $this->mandats->add($mandat);
            $mandat->setCoges($this);
        }

        return $this;
    }

    public function removeMandat(MandatCoges $mandat): static
    {
        if ($this->mandats->removeElement($mandat)) {
            // set the owning side to null (unless already changed)
            if ($mandat->getCoges() === $this) {
                $mandat->setCoges(null);
            }
        }

        return $this;
    }
}

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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\OneToMany(mappedBy: 'dren', targetEntity: Iepp::class, orphanRemoval: true)]
    private Collection $iepps;

    #[ORM\OneToMany(mappedBy: 'dren', targetEntity: Etablissement::class)]
    private Collection $etablissements;

    #[ORM\OneToMany(mappedBy: 'dren', targetEntity: Coges::class)]
    private Collection $dren_coges;

    public function __construct()
    {
        $this->iepps = new ArrayCollection();
        $this->etablissements = new ArrayCollection();
        $this->dren_coges = new ArrayCollection();
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
     * @return string|null
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @param string|null $telephone
     * @return Dren
     */
    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;
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
            $iepp->setDren($this);
        }

        return $this;
    }

    public function removeIepp(Iepp $iepp): static
    {
        if ($this->iepps->removeElement($iepp)) {
            // set the owning side to null (unless already changed)
            if ($iepp->getDren() === $this) {
                $iepp->setDren(null);
            }
        }

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
            $etablissement->setDren($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissement $etablissement): static
    {
        if ($this->etablissements->removeElement($etablissement)) {
            // set the owning side to null (unless already changed)
            if ($etablissement->getDren() === $this) {
                $etablissement->setDren(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Coges>
     */
    public function getDrenCoges(): Collection
    {
        return $this->dren_coges;
    }

    public function addDrenCoge(Coges $drenCoge): static
    {
        if (!$this->dren_coges->contains($drenCoge)) {
            $this->dren_coges->add($drenCoge);
            $drenCoge->setDren($this);
        }

        return $this;
    }

    public function removeDrenCoge(Coges $drenCoge): static
    {
        if ($this->dren_coges->removeElement($drenCoge)) {
            // set the owning side to null (unless already changed)
            if ($drenCoge->getDren() === $this) {
                $drenCoge->setDren(null);
            }
        }

        return $this;
    }

}

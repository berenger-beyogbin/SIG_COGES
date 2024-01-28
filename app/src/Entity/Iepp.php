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

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\ManyToOne(inversedBy: 'iepps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dren $dren = null;

    #[ORM\OneToMany(mappedBy: 'iepp', targetEntity: Etablissement::class)]
    private Collection $etablissements;

    #[ORM\OneToMany(mappedBy: 'iepp', targetEntity: Coges::class)]
    private Collection $iepp_coges;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
        $this->iepp_coges = new ArrayCollection();
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

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Iepp
     */
    public function setEmail(?string $email): self
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
     * @return Iepp
     */
    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;
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
            $etablissement->setIepp($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissement $etablissement): static
    {
        if ($this->etablissements->removeElement($etablissement)) {
            // set the owning side to null (unless already changed)
            if ($etablissement->getIepp() === $this) {
                $etablissement->setIepp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Coges>
     */
    public function getIeppCoges(): Collection
    {
        return $this->iepp_coges;
    }

    public function addIeppCoge(Coges $ieppCoge): static
    {
        if (!$this->iepp_coges->contains($ieppCoge)) {
            $this->iepp_coges->add($ieppCoge);
            $ieppCoge->setIepp($this);
        }

        return $this;
    }

    public function removeIeppCoge(Coges $ieppCoge): static
    {
        if ($this->iepp_coges->removeElement($ieppCoge)) {
            // set the owning side to null (unless already changed)
            if ($ieppCoge->getIepp() === $this) {
                $ieppCoge->setIepp(null);
            }
        }

        return $this;
    }

}

<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenoms = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $contact = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $entreprise = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $domaineActivite = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $localite = null;

    #[ORM\Column(length: 24, nullable: true)]
    private ?string $rib = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $domiciliation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $intituleCompte = null;

    #[ORM\OneToMany(mappedBy: 'fournisseur', targetEntity: Activite::class)]
    private Collection $activites;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): static
    {
        $this->prenoms = $prenoms;

        return $this;
    }
    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getLocalite(): ?string
    {
        return $this->localite;
    }

    public function setLocalite(string $localite): static
    {
        $this->localite = $localite;

        return $this;
    }

    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function setRib(string $rib): static
    {
        $this->rib = $rib;

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

    public function getIntituleCompte(): ?string
    {
        return $this->intituleCompte;
    }

    public function setIntituleCompte(string $intituleCompte): static
    {
        $this->intituleCompte = $intituleCompte;

        return $this;
    }

    public function getDomaineActivite(): ?string
    {
        return $this->domaineActivite;
    }

    public function setDomaineActivite(string $domaineActivite): static
    {
        $this->domaineActivite = $domaineActivite;

        return $this;
    }

    /**
     * @return Collection<int, Activite>
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): static
    {
        if (!$this->activites->contains($activite)) {
            $this->activites->add($activite);
            $activite->setFournisseur($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): static
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getFournisseur() === $this) {
                $activite->setFournisseur(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\MandatCogesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MandatCogesRepository::class)]
class MandatCoges
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateFin = null;

    private ?string $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'mandats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Coges $coges = null;

    #[ORM\OneToMany(mappedBy: 'mandatCoges', targetEntity: Pacc::class)]
    private Collection $paccs;

    public function __construct()
    {
        $this->paccs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getLibelle(): ?string
    {
        if($this->getDateDebut() && $this->getDateFin()){
            return $this->getDateDebut()?->format('Y') . ' - ' . $this->getDateFin()?->format('Y') ;
        }else{
            return null;
        }
    }

    /**
     * @param string|null $libelle
     * @return MandatCoges
     */
    public function setLibelle(?string $libelle): MandatCoges
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): static
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): static
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getCoges(): ?Coges
    {
        return $this->coges;
    }

    public function setCoges(?Coges $coges): static
    {
        $this->coges = $coges;

        return $this;
    }

    /**
     * @return Collection<int, Pacc>
     */
    public function getPaccs(): Collection
    {
        return $this->paccs;
    }

    public function addPacc(Pacc $pacc): static
    {
        if (!$this->paccs->contains($pacc)) {
            $this->paccs->add($pacc);
            $pacc->setMandatCoges($this);
        }

        return $this;
    }

    public function removePacc(Pacc $pacc): static
    {
        if ($this->paccs->removeElement($pacc)) {
            // set the owning side to null (unless already changed)
            if ($pacc->getMandatCoges() === $this) {
                $pacc->setMandatCoges(null);
            }
        }

        return $this;
    }

}

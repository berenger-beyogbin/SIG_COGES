<?php

namespace App\Entity;

use App\Repository\GratificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: GratificationRepository::class)]
#[ORM\Table(name: '`gratification`')]
class Gratification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $matricule = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fullname = null;   // video , text

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fonction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $janvier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fevrier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mars = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avril = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mai = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $juin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $juillet = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $aout = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $septembre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $octobre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $novembre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $decembre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created_at;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modified_at;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->modified_at = new \DateTime();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @param \DateTimeInterface|null $created_at
     * @return Member
     */
    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modified_at;
    }

    /**
     * @param \DateTimeInterface|null $modified_at
     * @return Member
     */
    public function setModifiedAt(?\DateTimeInterface $modified_at): self
    {
        $this->modified_at = $modified_at;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    /**
     * @param string|null $matricule
     * @return Gratification
     */
    public function setMatricule(?string $matricule): Gratification
    {
        $this->matricule = $matricule;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    /**
     * @param string|null $fullname
     * @return Gratification
     */
    public function setFullname(?string $fullname): Gratification
    {
        $this->fullname = $fullname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    /**
     * @param string|null $fonction
     * @return Gratification
     */
    public function setFonction(?string $fonction): Gratification
    {
        $this->fonction = $fonction;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJanvier(): ?string
    {
        return $this->janvier;
    }

    /**
     * @param string|null $janvier
     * @return Gratification
     */
    public function setJanvier(?string $janvier): Gratification
    {
        $this->janvier = $janvier;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFevrier(): ?string
    {
        return $this->fevrier;
    }

    /**
     * @param string|null $fevrier
     * @return Gratification
     */
    public function setFevrier(?string $fevrier): Gratification
    {
        $this->fevrier = $fevrier;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMars(): ?string
    {
        return $this->mars;
    }

    /**
     * @param string|null $mars
     * @return Gratification
     */
    public function setMars(?string $mars): Gratification
    {
        $this->mars = $mars;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAvril(): ?string
    {
        return $this->avril;
    }

    /**
     * @param string|null $avril
     * @return Gratification
     */
    public function setAvril(?string $avril): Gratification
    {
        $this->avril = $avril;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMai(): ?string
    {
        return $this->mai;
    }

    /**
     * @param string|null $mai
     * @return Gratification
     */
    public function setMai(?string $mai): Gratification
    {
        $this->mai = $mai;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJuin(): ?string
    {
        return $this->juin;
    }

    /**
     * @param string|null $juin
     * @return Gratification
     */
    public function setJuin(?string $juin): Gratification
    {
        $this->juin = $juin;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJuillet(): ?string
    {
        return $this->juillet;
    }

    /**
     * @param string|null $juillet
     * @return Gratification
     */
    public function setJuillet(?string $juillet): Gratification
    {
        $this->juillet = $juillet;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAout(): ?string
    {
        return $this->aout;
    }

    /**
     * @param string|null $aout
     * @return Gratification
     */
    public function setAout(?string $aout): Gratification
    {
        $this->aout = $aout;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSeptembre(): ?string
    {
        return $this->septembre;
    }

    /**
     * @param string|null $septembre
     * @return Gratification
     */
    public function setSeptembre(?string $septembre): Gratification
    {
        $this->septembre = $septembre;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOctobre(): ?string
    {
        return $this->octobre;
    }

    /**
     * @param string|null $octobre
     * @return Gratification
     */
    public function setOctobre(?string $octobre): Gratification
    {
        $this->octobre = $octobre;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNovembre(): ?string
    {
        return $this->novembre;
    }

    /**
     * @param string|null $novembre
     * @return Gratification
     */
    public function setNovembre(?string $novembre): Gratification
    {
        $this->novembre = $novembre;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDecembre(): ?string
    {
        return $this->decembre;
    }

    /**
     * @param string|null $decembre
     * @return Gratification
     */
    public function setDecembre(?string $decembre): Gratification
    {
        $this->decembre = $decembre;
        return $this;
    }


}

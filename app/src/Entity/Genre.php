<?php
// api/src/Entity/Review.php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GenreRepository;
use Doctrine\ORM\Mapping as ORM;

/** A review of a genre. */
#[ApiResource]
#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    /** The ID of this review. */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** The body of the review. */
    #[ORM\Column(length: 255)]
    public string $name= '';

    #[ORM\ManyToOne(inversedBy: 'genres')]
    private ?Movie $movie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): static
    {
        $this->movie = $movie;

        return $this;
    }

 }

<?php
// api/src/Entity/Movie.php
namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

#[ApiResource]
#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    /** The ID of this movie. */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** The title of this movie (or null if doesn't have one). */
    #[ORM\Column(length: 255)]
    public ?string $title = null;

    /** The original title of this movie. */
    #[ORM\Column(length: 255)]
    public string $original_language = '';

    /** The original title of this movie. */
    #[ORM\Column(length: 255)]
    public string $original_title = '';

    /** The description of this book. */
    #[ORM\Column(length: 255)]
    public string $overview = '';

    #[ORM\Column(length: 255)]
    public string $poster_path;

    #[ORM\Column(length: 255)]
    public string $backdrop_path;

    /** The release  date of this movie. */
    #[ORM\Column(type: 'datetime')]
    public ?\DateTimeImmutable $release_date = null;

    #[ORM\Column(type: 'boolean')]
    public bool $video;

    #[ORM\Column(type: 'float')]
    public float $popularity;

    #[ORM\Column(type: 'float')]
    public float $vote_average;

    #[ORM\Column(type: 'integer')]
    public int $vote_count;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Genre::class)]
    private Collection $genres;

    public function __construct()
    {
        $this->genres= new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->original_language;
    }

    /**
     * @param string $original_language
     */
    public function setOriginalLanguage(string $original_language): void
    {
        $this->original_language = $original_language;
    }

    /**
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->original_title;
    }

    /**
     * @param string $original_title
     */
    public function setOriginalTitle(string $original_title): void
    {
        $this->original_title = $original_title;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @return string
     */
    public function getPosterPath(): string
    {
        return $this->poster_path;
    }

    /**
     * @param string $poster_path
     */
    public function setPosterPath(string $poster_path): void
    {
        $this->poster_path = $poster_path;
    }

    /**
     * @return string
     */
    public function getBackdropPath(): string
    {
        return $this->backdrop_path;
    }

    /**
     * @param string $backdrop_path
     */
    public function setBackdropPath(string $backdrop_path): void
    {
        $this->backdrop_path = $backdrop_path;
    }


    /**
     * @return \DateTimeImmutable|null
     */
    public function getReleaseDate(): ?\DateTimeImmutable
    {
        return $this->release_date;
    }

    /**
     * @param \DateTimeImmutable|null $release_date
     */
    public function setReleaseDate(?\DateTimeImmutable $release_date): void
    {
        $this->release_date = $release_date;
    }

    /**
     * @return bool
     */
    public function isVideo(): bool
    {
        return $this->video;
    }

    /**
     * @param bool $video
     */
    public function setVideo(bool $video): void
    {
        $this->video = $video;
    }

    /**
     * @return float
     */
    public function getPopularity(): float
    {
        return $this->popularity;
    }

    /**
     * @param float $popularity
     */
    public function setPopularity(float $popularity): void
    {
        $this->popularity = $popularity;
    }

    /**
     * @return float
     */
    public function getVoteAverage(): float
    {
        return $this->vote_average;
    }

    /**
     * @param float $vote_average
     */
    public function setVoteAverage(float $vote_average): void
    {
        $this->vote_average = $vote_average;
    }

    /**
     * @return int
     */
    public function getVoteCount(): int
    {
        return $this->vote_count;
    }

    /**
     * @param int $vote_count
     */
    public function setVoteCount(int $vote_count): void
    {
        $this->vote_count = $vote_count;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
            $genre->setMovie($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        if ($this->genres->removeElement($genre)) {
            // set the owning side to null (unless already changed)
            if ($genre->getMovie() === $this) {
                $genre->setMovie(null);
            }
        }

        return $this;
    }


}

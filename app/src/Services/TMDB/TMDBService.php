<?php

namespace App\Services\TMDB;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client;

class TMDBService
{
    const BEARER_TOKEN = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI4NThiMGJmY2ZmMGQ2MDc4NTMyNzQ4NDcxOTFjOWQxMCIsInN1YiI6IjY1MWIwMDBkOWQ1OTJjMDE0MjYxZDRlYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.HOINZql94X2lEEqKK4iIAMJ78OA87929kQvaUIQKkpI';
    const URL_BASE = 'https://api.themoviedb.org/3/';
    const IMAGE_URL = 'https://image.tmdb.org/t/p/original';


    private GenreRepository $genreRepository;
    private MovieRepository $movieRepository;

    private EntityManagerInterface $entityManager;

    /**
     * @param GenreRepository $genreRepository
     * @param MovieRepository $movieRepository
     */
    public function __construct(GenreRepository $genreRepository, MovieRepository $movieRepository, EntityManagerInterface $entityManager)
    {
        $this->genreRepository = $genreRepository;
        $this->movieRepository = $movieRepository;
        $this->entityManager = $entityManager;
    }

    public function fetchMoviePopular(){
        $url = self::URL_BASE . "movie/popular";
        $response = $this->httpGet($url);

        foreach($response["results"] as $movieItem){
            $movie =  new Movie();
            $movie->setPopularity($movieItem['popularity']);
            $movie->setOverview($movieItem['overview']);
            $movie->setOriginalLanguage($movieItem['original_language']);
            $movie->setOriginalTitle($movieItem['original_title']);

            $path = "/var/www/html/public/api/tmdb/media";
            if(!file_exists($path)) mkdir($path,077, true);
            $data = file_get_contents(self::IMAGE_URL . $movieItem['backdrop_path']);
            file_put_contents( $path . $movieItem['backdrop_path'], $data);

            $data = file_get_contents(self::IMAGE_URL . $movieItem['poster_path']);
            file_put_contents($path . $movieItem['poster_path'], $data);

            $movie->setBackdropPath($movieItem['backdrop_path']);
            $movie->setPosterPath($movieItem['poster_path']);

            if(isset($movieItem['release_date'])) $movie->setReleaseDate(new \DateTimeImmutable($movieItem['release_date']));
            if(isset($movieItem['title']))  $movie->setTitle($movieItem['title']);
            if(isset($movieItem['video']))  $movie->setVideo($movieItem['video']);
            if(isset($movieItem['vote_average']))  $movie->setVoteAverage($movieItem['vote_average']);
            if(isset($movieItem['vote_count']))  $movie->setVoteCount($movieItem['vote_count']);

            foreach($movieItem['genre_ids'] as $genre){
                $genre = $this->genreRepository->find($genre);
                if($genre) $movie->addGenre($genre);
            }
            $this->entityManager->persist($movie);
        }

        $this->entityManager->flush();
    }

    public function fetchMovieTopRated(){
        $url = self::URL_BASE . "movie/top_rated";
        $response = $this->httpGet($url);
        $response = $this->httpGet($url);

        foreach($response["results"] as $movieItem){
            $movie =  new Movie();
            $movie->setPopularity($movieItem['popularity']);
            $movie->setOverview($movieItem['overview']);
            $movie->setOriginalLanguage($movieItem['original_language']);
            $movie->setOriginalTitle($movieItem['original_title']);

            $path = "/var/www/html/public/api/tmdb/media";
            if(!file_exists($path)) mkdir($path,077, true);
            $data = file_get_contents(self::IMAGE_URL . $movieItem['backdrop_path']);
            file_put_contents( $path . $movieItem['backdrop_path'], $data);

            $data = file_get_contents(self::IMAGE_URL . $movieItem['poster_path']);
            file_put_contents($path . $movieItem['poster_path'], $data);

            $movie->setBackdropPath($movieItem['backdrop_path']);
            $movie->setPosterPath($movieItem['poster_path']);

            if(isset($movieItem['release_date'])) $movie->setReleaseDate(new \DateTimeImmutable($movieItem['release_date']));
            if(isset($movieItem['title']))  $movie->setTitle($movieItem['title']);
            if(isset($movieItem['video']))  $movie->setVideo($movieItem['video']);
            if(isset($movieItem['vote_average']))  $movie->setVoteAverage($movieItem['vote_average']);
            if(isset($movieItem['vote_count']))  $movie->setVoteCount($movieItem['vote_count']);

            foreach($movieItem['genre_ids'] as $genre){
                $genre = $this->genreRepository->find($genre);
                if($genre) $movie->addGenre($genre);
            }
            $this->entityManager->persist($movie);
        }
        $this->entityManager->flush();
    }

    public function fetchMovieNowPlaying(){
        $url = self::URL_BASE . "movie/now_playing";
        $response = $this->httpGet($url);

        foreach($response["results"] as $movieItem){
            $movie =  new Movie();
            $movie->setPopularity($movieItem['popularity']);
            $movie->setOverview($movieItem['overview']);
            $movie->setOriginalLanguage($movieItem['original_language']);
            $movie->setOriginalTitle($movieItem['original_title']);

            $path = "/var/www/html/public/api/tmdb/media";
            if(!file_exists($path)) mkdir($path,077, true);
            $data = file_get_contents(self::IMAGE_URL . $movieItem['backdrop_path']);
            file_put_contents( $path . $movieItem['backdrop_path'], $data);

            $data = file_get_contents(self::IMAGE_URL . $movieItem['poster_path']);
            file_put_contents($path . $movieItem['poster_path'], $data);

            $movie->setBackdropPath($movieItem['backdrop_path']);
            $movie->setPosterPath($movieItem['poster_path']);

            if(isset($movieItem['release_date'])) $movie->setReleaseDate(new \DateTimeImmutable($movieItem['release_date']));
            if(isset($movieItem['title']))  $movie->setTitle($movieItem['title']);
            if(isset($movieItem['video']))  $movie->setVideo($movieItem['video']);
            if(isset($movieItem['vote_average']))  $movie->setVoteAverage($movieItem['vote_average']);
            if(isset($movieItem['vote_count']))  $movie->setVoteCount($movieItem['vote_count']);

            foreach($movieItem['genre_ids'] as $genre){
                $genre = $this->genreRepository->find($genre);
                if($genre) $movie->addGenre($genre);
            }
            $this->entityManager->persist($movie);
        }
        $this->entityManager->flush();
    }

    public function fetchMovieUpcoming(){
        $url = self::URL_BASE . "movie/upcoming";
        $response = $this->httpGet($url);

        foreach($response["results"] as $movieItem){
            $movie =  new Movie();
            $movie->setPopularity($movieItem['popularity']);
            $movie->setOverview($movieItem['overview']);
            $movie->setOriginalLanguage($movieItem['original_language']);
            $movie->setOriginalTitle($movieItem['original_title']);

            $path = "/var/www/html/public/api/tmdb/media";
            if(!file_exists($path)) mkdir($path,077, true);
            $data = file_get_contents(self::IMAGE_URL . $movieItem['backdrop_path']);
            file_put_contents( $path . $movieItem['backdrop_path'], $data);

            $data = file_get_contents(self::IMAGE_URL . $movieItem['poster_path']);
            file_put_contents($path . $movieItem['poster_path'], $data);

            $movie->setBackdropPath($movieItem['backdrop_path']);
            $movie->setPosterPath($movieItem['poster_path']);

            if(isset($movieItem['release_date'])) $movie->setReleaseDate(new \DateTimeImmutable($movieItem['release_date']));
            if(isset($movieItem['title']))  $movie->setTitle($movieItem['title']);
            if(isset($movieItem['video']))  $movie->setVideo($movieItem['video']);
            if(isset($movieItem['vote_average']))  $movie->setVoteAverage($movieItem['vote_average']);
            if(isset($movieItem['vote_count']))  $movie->setVoteCount($movieItem['vote_count']);

            foreach($movieItem['genre_ids'] as $genre){
                $genre = $this->genreRepository->find($genre);
                if($genre) $movie->addGenre($genre);
            }
            $this->entityManager->persist($movie);
        }

        $this->entityManager->flush();
    }

    public function fetchTrending(){
        $url = self::URL_BASE . "trending/all/week";
        $response = $this->httpGet($url);

        foreach($response["results"] as $movieItem){
            $movie =  new Movie();
            $movie->setPopularity($movieItem['popularity']);
            $movie->setOverview($movieItem['overview']);
            $movie->setOriginalLanguage($movieItem['original_language']);
            if (isset($movieItem['original_title'])) $movie->setOriginalTitle($movieItem['original_title']);

            $path = "/var/www/html/public/api/tmdb/media";
            if(!file_exists($path)) mkdir($path,077, true);
            $data = file_get_contents(self::IMAGE_URL . $movieItem['backdrop_path']);
            file_put_contents( $path . $movieItem['backdrop_path'], $data);

            $data = file_get_contents(self::IMAGE_URL . $movieItem['poster_path']);
            file_put_contents($path . $movieItem['poster_path'], $data);

            $movie->setBackdropPath($movieItem['backdrop_path']);
            $movie->setPosterPath($movieItem['poster_path']);

            if(isset($movieItem['release_date'])) $movie->setReleaseDate(new \DateTimeImmutable($movieItem['release_date']));
            if(isset($movieItem['title']))  $movie->setTitle($movieItem['title']);
            if(isset($movieItem['video']))  $movie->setVideo($movieItem['video']);
            if(isset($movieItem['vote_average']))  $movie->setVoteAverage($movieItem['vote_average']);
            if(isset($movieItem['vote_count']))  $movie->setVoteCount($movieItem['vote_count']);

            foreach($movieItem['genre_ids'] as $genre){
                $genre = $this->genreRepository->find($genre);
                if($genre) $movie->addGenre($genre);
            }
            $this->entityManager->persist($movie);
        }
        $this->entityManager->flush();
    }

    public function fetchGenreMovieList(){
        $url = self::URL_BASE . "genre/movie/list?language=en";
        $response = $this->httpGet($url);

        foreach($response["genres"] as $movieItem){
            $genre =  new Genre();
            $genre->setName($movieItem['name']);
            $this->entityManager->persist($genre);
        }
        $this->entityManager->flush();
    }

    public function fetchGenreTVList(){
        $url = self::URL_BASE . "genre/tv/list";
        $response = $this->httpGet($url);

        foreach($response["genres"] as $movieItem){
            $genre =  new Genre();
            $genre->setName($movieItem['name']);
            $this->entityManager->persist($genre);
        }
        $this->entityManager->flush();
    }


    public function httpGet($url){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '. self::BEARER_TOKEN
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }
}
